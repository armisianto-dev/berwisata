import { Component, OnInit } from '@angular/core'
import { Observable } from 'rxjs'
import { LoginResponse } from '../model/auth/login-response'
import { Profile } from '../model/auth/profile'
import { AuthService } from '../services/auth/auth.service'

@Component({
  selector: 'app-account',
  templateUrl: './account.component.html',
  styleUrls: ['./account.component.css'],
})
export class AccountComponent implements OnInit {
  isLogedIn: boolean = false
  authResponse: Observable<LoginResponse>

  defaultProfile = {
    name: '',
    email: '',
    photoUrl: '',
    gender: '',
    birthday: '',
    no_hp: '',
  }
  userProfile: Profile = this.defaultProfile

  constructor(private authService: AuthService) {}

  logoutProcess() {
    this.authService.signOut()
  }

  ngOnInit() {
    this.authService.check_auth()
    this.authService.loadUserProfile().subscribe(user => {
      this.userProfile = user
    })
  }
}
