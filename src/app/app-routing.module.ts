import { NgModule } from '@angular/core'
import { RouterModule, Routes } from '@angular/router'
import { CatalogueDetailComponent } from './catalogue/catalogue-detail/catalogue-detail.component'
import { HomeComponent } from './components/home/home.component'

const routes: Routes = [
  { path: '', redirectTo: '/home', pathMatch: 'full' },
  { path: 'home', component: HomeComponent },
  { path: 'customer', loadChildren: './customer/customer.module#CustomerModule' },
  { path: 'catalogue', loadChildren: './catalogue/catalogue.module#CatalogueModule' },
  { path: 'catalogue/catalogue-detail', component: CatalogueDetailComponent },
  {
    path: 'travel-booking',
    loadChildren: './travel-booking/travel-booking.module#TravelBookingModule',
  },
]

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
})
export class AppRoutingModule {}
