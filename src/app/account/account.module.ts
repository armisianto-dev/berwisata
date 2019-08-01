import { CommonModule } from '@angular/common'
import { NgModule } from '@angular/core'
import { FormsModule, ReactiveFormsModule } from '@angular/forms'
import {
  AuthServiceConfig,
  GoogleLoginProvider,
  SocialLoginModule,
} from 'angularx-social-login'
import { AccountRoutingModule } from './account-routing.module'
import { AccountComponent } from './account.component'
import { AuthComponent } from './auth/auth.component'

const configSocialAuth = new AuthServiceConfig([
  {
    id: GoogleLoginProvider.PROVIDER_ID,
    provider: new GoogleLoginProvider(
      '966390922787-j881i9fenn4e0afnfktvqg99t04unddb.apps.googleusercontent.com'
    ),
  },
])

export function provideConfig() {
  return configSocialAuth
}

@NgModule({
  declarations: [AccountComponent, AuthComponent],
  imports: [
    CommonModule,
    AccountRoutingModule,
    FormsModule,
    ReactiveFormsModule,
    SocialLoginModule,
  ],
  providers: [
    {
      provide: AuthServiceConfig,
      useFactory: provideConfig,
    },
  ],
})
export class AccountModule {}
