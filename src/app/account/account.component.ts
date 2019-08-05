import { Component, OnInit } from '@angular/core'
import { Router } from '@angular/router'
import { AuthService as SocialAuthService, SocialUser } from 'angularx-social-login'
import { Observable } from 'rxjs'
import { Profile } from '../model/auth/profile'
import { SocialAccounts } from '../model/auth/social-accounts'
import { AuthService } from '../services/auth/auth.service'

@Component({
  selector: 'app-account',
  templateUrl: './account.component.html',
  styleUrls: ['./account.component.css'],
})
export class AccountComponent implements OnInit {
  isLogedIn: boolean = false
  defaultProfile = {
    name: '',
    email: '',
    photoUrl: '',
    gender: '',
    birthday: '',
    no_hp: '',
  }
  userProfile: Profile = this.defaultProfile
  userSocial: SocialUser

  socialAccounts: Observable<SocialAccounts[]>

  constructor(
    private authService: AuthService,
    private socialAuthService: SocialAuthService,
    private router: Router
  ) {}

  logoutProcess() {
    this.authService.signOut()
  }

  connectSocial(provider: string): void {
    this.router.navigateByUrl('/account/connect/' + provider)
  }

  ngOnInit() {
    this.authService.check_auth()
    this.socialAccounts = this.authService.loadSocialAccounts()
    this.authService.loadUserProfile().subscribe(user => {
      this.userProfile = user
    })
  }
}
