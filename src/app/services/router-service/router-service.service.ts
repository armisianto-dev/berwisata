import { Injectable } from '@angular/core'
import { ActivatedRouteSnapshot, Router } from '@angular/router'

@Injectable({
  providedIn: 'root',
})
export class RouterServiceService {
  constructor(private router: Router) {}

  public getRouteData(data: string): any {
    const root = this.router.routerState.snapshot.root
    return this.lastChild(root).data[data]
  }

  public getRouteAllData(): any {
    const root = this.router.routerState.snapshot.root
    return this.lastChild(root).data
  }

  public changeRouteData(data: string, update: any) {
    const root = this.router.routerState.snapshot.root
    this.lastChild(root).data[data] = update
  }

  private lastChild(route: ActivatedRouteSnapshot): ActivatedRouteSnapshot {
    if (route.firstChild) {
      return this.lastChild(route.firstChild)
    } else {
      return route
    }
  }
}
