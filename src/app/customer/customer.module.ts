import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CustomerRoutingModule } from './customer-routing.module';
import { AccountComponent } from './account/account.component';
import { CustomerComponent } from './customer.component';


@NgModule({
  declarations: [AccountComponent, CustomerComponent],
  imports: [
    CommonModule,
    CustomerRoutingModule
  ]
})
export class CustomerModule { }
