import { NgModule } from '@angular/core'
import { RouterModule, Routes } from '@angular/router'
import { TravelBookingComponent } from './travel-booking.component'

const routes: Routes = [
  {
    path: '',
    component: TravelBookingComponent,
    children: [{ path: '', redirectTo: '/travel-booking', pathMatch: 'full' }],
  },
]

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TravelBookingRoutingModule {}
