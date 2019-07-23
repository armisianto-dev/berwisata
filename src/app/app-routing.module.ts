import { NgModule } from '@angular/core'
import { RouterModule, Routes } from '@angular/router'
import { CatalogueDetailComponent } from './catalogue/catalogue-detail/catalogue-detail.component'
import { HomeComponent } from './components/home/home.component'

const routes: Routes = [
  {
    path: '',
    redirectTo: '/home',
    pathMatch: 'full',
    data: {
      title: 'Home | Berwisata',
      nav_title: 'Berwisata',
      back: false,
      back_path: '',
    },
  },
  {
    path: 'home',
    component: HomeComponent,
    data: {
      title: 'Home | Berwisata',
      nav_title: 'Berwisata',
      back: false,
      back_path: '',
    },
  },
  {
    path: 'customer',
    loadChildren: './customer/customer.module#CustomerModule',
    data: {
      title: 'Customer | Berwisata',
      nav_title: 'Customer',
      back: true,
      back_path: 'home',
    },
  },
  {
    path: 'catalogue',
    loadChildren: './catalogue/catalogue.module#CatalogueModule',
    data: {
      title: 'Katalog | Berwisata',
      nav_title: 'Katalog',
      back: true,
      back_path: 'home',
    },
  },
  {
    path: 'catalogue/:catalogueId',
    component: CatalogueDetailComponent,
    data: {
      title: 'Katalog Detail | Berwisata',
      nav_title: 'Katalog Detail',
      back: true,
      back_path: 'catalogue',
    },
  },
  {
    path: 'travel-booking',
    loadChildren: './travel-booking/travel-booking.module#TravelBookingModule',
    data: {
      title: 'Booking | Berwisata',
      nav_title: 'Booking',
      back: true,
      back_path: 'home',
    },
  },
]

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
})
export class AppRoutingModule {}
