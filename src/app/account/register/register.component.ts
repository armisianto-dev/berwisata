import { Component, OnInit } from '@angular/core'
import { FormBuilder, FormGroup, Validators } from '@angular/forms'
import { matchingValue, numberOnly } from 'src/app/app-helper/app-form-validators'

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
})
export class RegisterComponent implements OnInit {
  registerForm: FormGroup
  constructor(private fb: FormBuilder) {
    this.createRegisterForm()
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
        ],
      }
    )
  }
  ngOnInit() {}
}
