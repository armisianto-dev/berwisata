import { Component, OnInit } from '@angular/core'
import { Router } from '@angular/router'

@Component({
  selector: 'app-account',
  templateUrl: './account.component.html',
  styleUrls: ['./account.component.css'],
})
export class AccountComponent implements OnInit {
  isLogedIn: boolean = false
  constructor(private router: Router) {}

  logoutProcess() {
    localStorage.removeItem('session_login')
    this.router.navigate(['/home'])
  }

  ngOnInit() {
    if (!localStorage.getItem('session_login')) {
      this.router.navigate(['/account/auth'])
    }
  }
}
