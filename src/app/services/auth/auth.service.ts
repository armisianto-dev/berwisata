import { HttpClient, HttpHeaders } from '@angular/common/http'
import { Injectable } from '@angular/core'
import { LoginData } from 'src/app/model/auth/login-data'
import { environment } from 'src/environments/environment'

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  baseUrl = environment.web_services
  headersPost = new HttpHeaders()
    .set('Content-Type', 'multipart/form-data')
    .set('Accept', 'application/json')
  httpOptionsPost = {
    headers: this.headersPost,
  }

  constructor(private httpClient: HttpClient) {}

  auth(data) {
    return this.httpClient.post<LoginData>(
      this.baseUrl + 'auth/token/',
      data,
      this.httpOptionsPost
    )
  }
}
