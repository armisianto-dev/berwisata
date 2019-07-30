import { CommonModule } from '@angular/common'
import { NgModule } from '@angular/core'
import { FormsModule } from '@angular/forms'
import { AccountRoutingModule } from './account-routing.module'
import { AccountComponent } from './account.component'
import { AuthComponent } from './auth/auth.component'

@NgModule({
  declarations: [AccountComponent, AuthComponent],
  imports: [CommonModule, AccountRoutingModule, FormsModule],
})
export class AccountModule {}
