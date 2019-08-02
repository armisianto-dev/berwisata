import { HttpClient } from '@angular/common/http'
import { Injectable } from '@angular/core'
import { CanActivate, Router } from '@angular/router'
import { AuthResponse } from 'src/app/model/auth/auth-response'
import { environment } from 'src/environments/environment'

@Injectable({
  providedIn: 'root',
})
export class AuthguardService implements CanActivate {
  baseUrl = environment.web_services

  constructor(private httpCLient: HttpClient, private router: Router) {}

  canActivate(): boolean {
    let token = localStorage.getItem('session_login')
    if (!token) {
      this.router.navigate(['account/auth'])
      return false
    }

    this.httpCLient
      .get<AuthResponse>(this.baseUrl + 'auth/token/check_auth?token=' + token)
      .subscribe(
        response => {
          if (response.status === false) {
            this.router.navigate(['account/auth'])
            return false
          }
        },
        error => {
          this.router.navigate(['account/auth'])
          return false
        }
      )
    return true
  }
}
