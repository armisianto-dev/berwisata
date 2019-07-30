import { Component, OnInit } from '@angular/core'
import { Title } from '@angular/platform-browser'
import { NavigationEnd, Router, RouterEvent } from '@angular/router'
import { environment } from 'src/environments/environment'
import { IRouter } from './model/router/router'
import { routerTransition } from './router.animations'
import { CatalogueService } from './services/catalogue/catalogue.service'
import { RouterServiceService } from './services/router-service/router-service.service'

@Component({
  selector: 'app-root',
  animations: [routerTransition],
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
})
export class AppComponent implements OnInit {
  env = environment
  currentRouter: IRouter
  public constructor(
    private router: Router,
    private titleService: Title,
    private routeService: RouterServiceService,
    private catalogueService: CatalogueService
  ) {
    this.router.events.subscribe((event: RouterEvent) => {
      if (event instanceof NavigationEnd) {
        this.titleService.setTitle(this.routeService.getRouteData('title'))
        this.currentRouter = this.routeService.getRouteAllData()
      }
    })
  }

  getState() {
    return this.routeService.getRouteData('state')
  }

  ngOnInit() {
    this.titleService.setTitle(this.routeService.getRouteData('title'))
    this.currentRouter = this.routeService.getRouteAllData()
  }
}
