import { HttpClient } from '@angular/common/http'
import { Injectable } from '@angular/core'
import { Observable } from 'rxjs'
import { LoginData } from 'src/app/model/auth/login-data'
import { LoginResponse } from 'src/app/model/auth/login-response'
import { environment } from 'src/environments/environment'

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  baseUrl = environment.web_services

  constructor(private httpClient: HttpClient) {}

  auth(loginData: LoginData): Observable<LoginResponse> {
    return this.httpClient.post<LoginResponse>(this.baseUrl + 'auth/token', loginData)
  }

  check_auth(token: string) {
    return this.httpClient.get<LoginResponse>(
      this.baseUrl + 'auth/token/check_auth?token=' + token
    )
  }
}
