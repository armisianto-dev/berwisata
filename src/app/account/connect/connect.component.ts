import { Component, OnInit } from '@angular/core'
import { ActivatedRoute, Router } from '@angular/router'
import {
  AuthService as SocialAuthService,
  FacebookLoginProvider,
  GoogleLoginProvider,
  SocialUser,
} from 'angularx-social-login'
import { Profile } from 'src/app/model/auth/profile'
import { AuthService } from 'src/app/services/auth/auth.service'

@Component({
  selector: 'app-connect',
  templateUrl: './connect.component.html',
  styleUrls: ['./connect.component.css'],
})
export class ConnectComponent implements OnInit {
  provider: string
  defaultProfile = {
    name: '',
    email: '',
    photoUrl: '',
    gender: '',
    birthday: '',
    no_hp: '',
  }
  userProfile: Profile = this.defaultProfile
  userSocial: SocialUser = {
    provider: '',
    id: '',
    email: '',
    name: '',
    photoUrl: '',
    firstName: '',
    lastName: '',
    authToken: '',
    idToken: '',
    authorizationCode: '',
    facebook: '',
    linkedIn: '',
  }

  connectMessage: string = ''

  constructor(
    private authService: AuthService,
    private socialAuthService: SocialAuthService,
    private router: Router,
    private route: ActivatedRoute
  ) {}

  connectSocial() {
    this.authService.connectSocial(this.userSocial).subscribe(
      response => {
        if (response.status == true) {
          this.router.navigateByUrl('/account')
        } else {
          this.connectMessage = 'Akun sudah terdaftar, gunakan akun lain'
        }
      },
      error => {
        this.connectMessage = 'Akun sudah terdaftar, gunakan akun lain'
      }
    )
  }

  ngOnInit() {
    this.provider = this.route.snapshot.params.provider

    this.authService.loadUserProfile().subscribe(user => {
      this.userProfile = user
    })

    if (this.provider == 'GOOGLE') {
      this.socialAuthService.signIn(GoogleLoginProvider.PROVIDER_ID).then(response => {
        this.socialAuthService.authState.subscribe(user => {
          this.userSocial = user
        })
      })
    } else if (this.provider == 'FACEBOOK') {
      this.socialAuthService.signIn(FacebookLoginProvider.PROVIDER_ID).then(response => {
        this.socialAuthService.authState.subscribe(user => {
          this.userSocial = user
        })
      })
    }
  }
}
