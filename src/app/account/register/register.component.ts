import { Component, OnInit } from '@angular/core'
import { FormBuilder, FormGroup, Validators } from '@angular/forms'
import { DateAdapter, MAT_DATE_FORMATS } from '@angular/material'
import { Router } from '@angular/router'
import {
  leadingZero,
  matchingValue,
  numberOnly,
} from 'src/app/app-helper/app-form-validators'
import { AppDateAdapter, APP_DATE_FORMATS } from 'src/app/app-helper/format-datepicker'
import { AuthService } from 'src/app/services/auth/auth.service'

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
  providers: [
    { provide: DateAdapter, useClass: AppDateAdapter },
    { provide: MAT_DATE_FORMATS, useValue: APP_DATE_FORMATS },
  ],
})
export class RegisterComponent implements OnInit {
  registerForm: FormGroup
  registerMessage: string = ''
  constructor(
    private fb: FormBuilder,
    private dateAdapter: DateAdapter<any>,
    private authService: AuthService,
    private router: Router
  ) {
    this.createRegisterForm()
    this.dateAdapter.setLocale('id')
  }

  createRegisterForm() {
    this.registerForm = this.fb.group(
      {
        user_mail: ['', [Validators.required, Validators.email]],
        password: ['', Validators.required],
        confirm_password: ['', Validators.required],
        user_no_hp: ['', Validators.required],
        user_alias: ['', Validators.required],
        user_birthday: ['', Validators.required],
        user_gender: ['', Validators.required],
      },
      {
        validator: [
          matchingValue('password', 'confirm_password'),
          numberOnly('user_no_hp'),
          leadingZero('user_no_hp'),
        ],
      }
    )
  }

  closeAlert() {
    this.registerMessage = ''
  }

  registerProcess() {
    const formData = this.registerForm

    this.authService.registerAccount(formData).subscribe(
      response => {
        if (response.status === true) {
          this.router.navigateByUrl('/account/auth')
        } else {
          this.registerMessage = response.message
        }
      },
      error => {
        this.registerMessage = error.error.message
      }
    )
  }
  ngOnInit() {}
}
