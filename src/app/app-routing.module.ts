import { NgModule } from '@angular/core'
import { RouterModule, Routes } from '@angular/router'
import { AuthComponent } from './account/auth/auth.component'
import { CatalogueDetailComponent } from './catalogue/catalogue-detail/catalogue-detail.component'
import { HomeComponent } from './components/home/home.component'
import { AuthguardService as AuthGuard } from './services/auth/authguard.service'

const routes: Routes = [
  {
    path: '',
    redirectTo: '/home',
    pathMatch: 'full',
    data: {
      state: 'home',
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
      state: 'home',
      title: 'Home | Berwisata',
      nav_title: 'Berwisata',
      back: false,
      back_path: '',
    },
  },
  {
    path: 'account',
    loadChildren: './account/account.module#AccountModule',
    data: {
      state: 'account',
      title: 'Account | Berwisata',
      nav_title: 'Account',
      back: true,
      back_path: 'home',
    },
  },
  {
    path: 'account/auth',
    component: AuthComponent,
    data: {
      state: 'account',
      title: 'Login | Berwisata',
      nav_title: 'Login',
      back: true,
      back_path: 'home',
    },
  },
  {
    path: 'catalogue',
    loadChildren: './catalogue/catalogue.module#CatalogueModule',
    data: {
      state: 'catalogue',
      title: 'Katalog | Berwisata',
      nav_title: 'Katalog',
      back: true,
      back_path: 'home',
    },
  },
  {
    path: 'catalogue/catalogue-detail/:catalogueId',
    component: CatalogueDetailComponent,
    data: {
      state: 'catalogue-detail',
      title: 'Katalog Detail | Berwisata',
      nav_title: 'Katalog Detail',
      back: true,
      back_path: 'catalogue',
    },
  },
  {
    path: 'travel-booking',
    loadChildren: './travel-booking/travel-booking.module#TravelBookingModule',
    canActivate: [AuthGuard],
    data: {
      state: 'travel-booking',
      title: 'Booking | Berwisata',
      nav_title: 'Booking',
      back: true,
      back_path: 'home',
    },
  },
]

@NgModule({
  imports: [
    RouterModule.forRoot(routes, {
      useHash: false,
    }),
  ],
  exports: [RouterModule],
})
export class AppRoutingModule {}
