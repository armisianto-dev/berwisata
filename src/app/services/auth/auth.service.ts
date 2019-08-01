import { HttpClient } from '@angular/common/http'
import { Injectable } from '@angular/core'
import { Router } from '@angular/router'
import { AuthService as SocialAuthService } from 'angularx-social-login'
import { Observable } from 'rxjs'
import { AuthResponse } from 'src/app/model/auth/auth-response'
import { LoginData } from 'src/app/model/auth/login-data'
import { LoginResponse } from 'src/app/model/auth/login-response'
import { environment } from 'src/environments/environment'

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  baseUrl = environment.web_services

  constructor(
    private httpClient: HttpClient,
    private router: Router,
    private socialAuthService: SocialAuthService
  ) {}

  auth(loginData: LoginData): Observable<LoginResponse> {
    return this.httpClient.post<LoginResponse>(this.baseUrl + 'auth/token', loginData)
  }

  authGoogle(email: string): Observable<LoginResponse> {
    return this.httpClient.get<LoginResponse>(
      this.baseUrl + 'auth/token/auth_email?email=' + email
    )
  }

  check_auth(): boolean {
    let token = localStorage.getItem('session_login')

    this.httpClient
      .get<AuthResponse>(this.baseUrl + 'auth/token/check_auth?token=' + token)
      .subscribe(
        response => {
          if (response.status === false) {
            this.router.navigate(['/account/auth'])
            return false
          }
        },
        error => {
          this.router.navigate(['/account/auth'])
          return false
        }
      )
    return true
  }

  signOut() {
    localStorage.removeItem('session_login')
    this.socialAuthService.signOut()
    this.router.navigate(['/home'])
  }
}
