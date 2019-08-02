import { registerLocaleData } from '@angular/common'
import { HttpClientModule } from '@angular/common/http'
import id from '@angular/common/locales/id'
import { LOCALE_ID, NgModule } from '@angular/core'
import { FlexLayoutModule } from '@angular/flex-layout'
import { BrowserModule } from '@angular/platform-browser'
import { BrowserAnimationsModule } from '@angular/platform-browser/animations'
import { NgbModule } from '@ng-bootstrap/ng-bootstrap'
import { LoadingBarHttpClientModule } from '@ngx-loading-bar/http-client'
import { LoadingBarRouterModule } from '@ngx-loading-bar/router'
import { AngularFontAwesomeModule } from 'angular-font-awesome'
import { AccountModule } from './account/account.module'
import { AppRoutingModule } from './app-routing.module'
import { AppComponent } from './app.component'
import { CatalogueModule } from './catalogue/catalogue.module'
import { HomeComponent } from './components/home/home.component'
import { MaterialModule } from './material.module'
import { RouterServiceService } from './services/router-service/router-service.service'
import { TravelBookingModule } from './travel-booking/travel-booking.module'
import { WelcomeModule } from './welcome/welcome.module'

// register locale data
registerLocaleData(id, 'id')

@NgModule({
  declarations: [AppComponent, HomeComponent],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    MaterialModule,
    FlexLayoutModule,
    WelcomeModule,
    CatalogueModule,
    TravelBookingModule,
    AngularFontAwesomeModule,
    NgbModule,
    LoadingBarHttpClientModule,
    LoadingBarRouterModule,
    AccountModule,
    HttpClientModule,
  ],
  providers: [RouterServiceService, { provide: LOCALE_ID, useValue: 'id' }],
  bootstrap: [AppComponent],
})
export class AppModule {}
