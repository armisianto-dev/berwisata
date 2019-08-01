import { Component, OnInit } from '@angular/core'
import { FormBuilder, FormGroup, Validators } from '@angular/forms'
import { Router } from '@angular/router'
import {
  AuthService as SocialAuthService,
  GoogleLoginProvider,
} from 'angularx-social-login'
import { Observable } from 'rxjs'
import { LoginResponse } from 'src/app/model/auth/login-response'
import { AuthService } from 'src/app/services/auth/auth.service'

@Component({
  selector: 'app-auth',
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.css'],
})
export class AuthComponent implements OnInit {
  loginData: any = {}
  loginMessage: string = ''
  loginForm: FormGroup

  loginResponse: Observable<LoginResponse>

  constructor(
    private router: Router,
    private authService: AuthService,
    private fb: FormBuilder,
    private socialAuthService: SocialAuthService
  ) {
    this.createLoginForm()
  }

  createLoginForm() {
    this.loginForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', Validators.required],
    })
  }

  loginProcess() {
    this.authService.auth(this.loginForm.value).subscribe(
      response => {
        if (response.status) {
          console.log(response.message)
          localStorage.setItem('session_login', response.token)
          this.router.navigate(['/account'])
        }
      },
      error => {
        this.loginMessage = error.error.error.message
      }
    )
  }

  signInWithGoogle(): void {
    this.socialAuthService.signIn(GoogleLoginProvider.PROVIDER_ID).then(response => {
      this.authService.authGoogle(response.email).subscribe(
        response => {
          if (response.status) {
            console.log('Login berhasil')
            localStorage.setItem('session_login', response.token)
            this.router.navigate(['/account'])
          } else {
            console.log(response.message)
          }
        },
        error => {
          this.loginMessage = error.error.error.message
        }
      )
    })
  }

  ngOnInit() {}
}
