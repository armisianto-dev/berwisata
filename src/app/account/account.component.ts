import { Component, OnInit } from '@angular/core'
import { Router } from '@angular/router'
import { Observable } from 'rxjs'
import { LoginResponse } from '../model/auth/login-response'
import { AuthService } from '../services/auth/auth.service'

@Component({
  selector: 'app-account',
  templateUrl: './account.component.html',
  styleUrls: ['./account.component.css'],
})
export class AccountComponent implements OnInit {
  isLogedIn: boolean = false
  authResponse: Observable<LoginResponse>
  constructor(private router: Router, private authService: AuthService) {}

  logoutProcess() {
    this.authService.signOut()
  }

  ngOnInit() {
    this.authService.check_auth()
  }
}
