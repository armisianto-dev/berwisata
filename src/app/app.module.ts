import { NgModule } from '@angular/core'
import { FlexLayoutModule } from '@angular/flex-layout'
import { BrowserModule } from '@angular/platform-browser'
import { BrowserAnimationsModule } from '@angular/platform-browser/animations'
import { AppRoutingModule } from './app-routing.module'
import { AppComponent } from './app.component'
import { HomeComponent } from './components/home/home.component'
import { CustomerModule } from './customer/customer.module'
import { MaterialModule } from './material.module';
import { WelcomeModule } from './welcome/welcome.module';
import { CatalogueModule } from './catalogue/catalogue.module'

@NgModule({
  declarations: [AppComponent, HomeComponent],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    MaterialModule,
    CustomerModule,
    FlexLayoutModule,
    WelcomeModule,
    CatalogueModule,
  ],
  providers: [],
  bootstrap: [AppComponent],
})
export class AppModule {}
