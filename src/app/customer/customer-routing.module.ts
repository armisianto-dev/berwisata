import { NgModule } from '@angular/core'
import { RouterModule, Routes } from '@angular/router'
import { AccountComponent } from './account/account.component'
import { CustomerComponent } from './customer.component'

const routes: Routes = [
  {
    path: '',
    component: CustomerComponent,
    children: [
      { path: '', redirectTo: '/customer/account', pathMatch: 'full' },
      { path: 'account', component: AccountComponent },
    ],
  },
]

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CustomerRoutingModule {}
