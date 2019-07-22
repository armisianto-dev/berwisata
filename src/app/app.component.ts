import { Component, OnInit } from '@angular/core'
import { Title } from '@angular/platform-browser'
import { NavigationEnd, Router, RouterEvent } from '@angular/router'
import { IRouter } from './model/router/router'
import { RouterServiceService } from './services/router-service/router-service.service'

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
})
export class AppComponent implements OnInit {
  currentRouter: IRouter
  public constructor(
    private router: Router,
    private titleService: Title,
    private routeService: RouterServiceService
  ) {
    this.router.events.subscribe((event: RouterEvent) => {
      if (event instanceof NavigationEnd) {
        this.titleService.setTitle(this.routeService.getRouteData('title'))
        this.currentRouter = this.routeService.getRouteAllData()
      }
    })
  }

  ngOnInit() {
    this.titleService.setTitle(this.routeService.getRouteData('title'))
    this.currentRouter = this.routeService.getRouteAllData()
  }
}
