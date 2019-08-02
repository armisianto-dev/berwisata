import { HttpClient } from '@angular/common/http'
import { Injectable } from '@angular/core'
import { Router } from '@angular/router'
import { AuthService as SocialAuthService, SocialUser } from 'angularx-social-login'
import { BehaviorSubject, Observable } from 'rxjs'
import { AuthResponse } from 'src/app/model/auth/auth-response'
import { LoginResponse } from 'src/app/model/auth/login-response'
import { Profile } from 'src/app/model/auth/profile'
import { environment } from 'src/environments/environment'

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  baseUrl = environment.web_services

  user: SocialUser
  defaultProfile = {
    name: '',
    email: '',
    photoUrl: '',
    gender: '',
    birthday: '',
    no_hp: '',
  }
  userProfile: Profile = this.defaultProfile
  profileChange: BehaviorSubject<Profile>

  constructor(
    private httpClient: HttpClient,
    private router: Router,
    private socialAuthService: SocialAuthService
  ) {
    this.profileChange = new BehaviorSubject(this.userProfile)
  }

  auth(email: string, password: string): Observable<LoginResponse> {
    return this.httpClient.post<LoginResponse>(this.baseUrl + 'auth/token', {
      email,
      password,
    })
  }

  authSocial(): Observable<LoginResponse> {
    this.loadSocialUser()
    const body = {
      social_id: this.user.id,
      provider: this.user.provider,
      name: this.user.name,
      email: this.user.email,
      photoUrl: this.user.photoUrl,
    }
    return this.httpClient.post<LoginResponse>(
      this.baseUrl + 'auth/token/auth_social',
      body
    )
  }

  check_auth(): boolean {
    const token = localStorage.getItem('session_login')
    if (!token) {
      this.userProfile = this.defaultProfile
      this.profileChange.next(this.userProfile)
      this.router.navigateByUrl('/account/auth')
      return false
    }

    this.httpClient
      .get<AuthResponse>(this.baseUrl + 'auth/token/check_auth?token=' + token)
      .subscribe(
        response => {
          if (response.status === false) {
            localStorage.removeItem('session_login')
            this.router.navigateByUrl('/account/auth')
            return false
          }
        },
        error => {
          localStorage.removeItem('session_login')
          this.router.navigateByUrl('/account/auth')
          return false
        }
      )
    return true
  }

  loadUserProfile() {
    let token = localStorage.getItem('session_login')
    return this.httpClient.get<Profile>(
      this.baseUrl + 'auth/token/profile?token=' + token
    )
  }

  setUserProfile() {
    let token = localStorage.getItem('session_login')
    this.httpClient
      .get<Profile>(this.baseUrl + 'auth/token/profile?token=' + token)
      .subscribe(
        user => {
          if (user) {
            this.userProfile = user
            this.profileChange.next(this.userProfile)
          } else {
            this.userProfile = this.defaultProfile
            this.profileChange.next(this.userProfile)
          }
        },
        error => {
          this.userProfile = this.defaultProfile
          this.profileChange.next(this.userProfile)
        }
      )
  }

  loadSocialUser() {
    this.socialAuthService.authState.subscribe(user => {
      this.user = user
    })
  }

  signOut() {
    localStorage.removeItem('session_login')
    this.socialAuthService.signOut()
    this.setUserProfile()
    this.router.navigateByUrl('/home')
  }
}
