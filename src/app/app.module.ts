import { NgModule } from '@angular/core'
import { FlexLayoutModule } from '@angular/flex-layout'
import { BrowserModule } from '@angular/platform-browser'
import { BrowserAnimationsModule } from '@angular/platform-browser/animations'
import { NgbModule } from '@ng-bootstrap/ng-bootstrap'
import { LoadingBarHttpClientModule } from '@ngx-loading-bar/http-client'
import { LoadingBarRouterModule } from '@ngx-loading-bar/router'
import { AngularFontAwesomeModule } from 'angular-font-awesome'
import { AppRoutingModule } from './app-routing.module'
import { AppComponent } from './app.component'
import { CatalogueModule } from './catalogue/catalogue.module'
import { HomeComponent } from './components/home/home.component'
import { MaterialModule } from './material.module'
import { RouterServiceService } from './services/router-service/router-service.service'
import { TravelBookingModule } from './travel-booking/travel-booking.module'
import { WelcomeModule } from './welcome/welcome.module';
import { AccountModule } from './account/account.module'

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
  ],
  providers: [RouterServiceService],
  bootstrap: [AppComponent],
})
export class AppModule {}
