import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TravelBookingRoutingModule } from './travel-booking-routing.module';
import { TravelBookingComponent } from './travel-booking.component';


@NgModule({
  declarations: [TravelBookingComponent],
  imports: [
    CommonModule,
    TravelBookingRoutingModule
  ]
})
export class TravelBookingModule { }
