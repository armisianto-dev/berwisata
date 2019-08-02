import { Component, OnInit } from '@angular/core'
import { Title } from '@angular/platform-browser'
import { NavigationEnd, Router, RouterEvent } from '@angular/router'
import { environment } from 'src/environments/environment'
import { Profile } from './model/auth/profile'
import { IRouter } from './model/router/router'
import { routerTransition } from './router.animations'
import { AuthService } from './services/auth/auth.service'
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

  userProfile: Profile = { name: '', email: '', photoUrl: '' }

  public constructor(
    private router: Router,
    private titleService: Title,
    private routeService: RouterServiceService,
    private authService: AuthService
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

    this.authService.profileChange.subscribe(user => {
      this.userProfile = user
    })
  }

  ngAfterViewInit(): void {
    this.authService.setUserProfile()
    this.authService.profileChange.subscribe(user => {
      this.userProfile = user
    })
  }
}
