import { CommonModule } from '@angular/common'
import { NgModule } from '@angular/core'
import { FormsModule, ReactiveFormsModule } from '@angular/forms'
import {
  MatDatepickerModule,
  MatFormFieldModule,
  MatNativeDateModule,
  MatRadioModule,
} from '@angular/material'
import { NgbAlertModule } from '@ng-bootstrap/ng-bootstrap'
import {
  AuthServiceConfig,
  FacebookLoginProvider,
  GoogleLoginProvider,
  SocialLoginModule,
} from 'angularx-social-login'
import { AccountRoutingModule } from './account-routing.module'
import { AccountComponent } from './account.component'
import { AuthComponent } from './auth/auth.component'
import { ConnectComponent } from './connect/connect.component'
import { RegisterComponent } from './register/register.component'

const configSocialAuth = new AuthServiceConfig([
  {
    id: GoogleLoginProvider.PROVIDER_ID,
    provider: new GoogleLoginProvider(
      '966390922787-j881i9fenn4e0afnfktvqg99t04unddb.apps.googleusercontent.com'
    ),
  },
  {
    id: FacebookLoginProvider.PROVIDER_ID,
    provider: new FacebookLoginProvider('2362329367367590'),
  },
])

export function provideConfig() {
  return configSocialAuth
}

@NgModule({
  declarations: [AccountComponent, AuthComponent, RegisterComponent, ConnectComponent],
  imports: [
    CommonModule,
    AccountRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    SocialLoginModule,
    NgbAlertModule,
    MatDatepickerModule,
    MatFormFieldModule,
    MatNativeDateModule,
    MatRadioModule,
  ],
  providers: [
    {
      provide: AuthServiceConfig,
      useFactory: provideConfig,
    },
  ],
})
export class AccountModule {}
