import { Component, OnInit } from '@angular/core'
import { Router } from '@angular/router'
import { AuthService } from 'src/app/services/auth/auth.service'

@Component({
  selector: 'app-auth',
  templateUrl: './auth.component.html',
  styleUrls: ['./auth.component.css'],
})
export class AuthComponent implements OnInit {
  loginData: any = {}
  constructor(private router: Router, private authService: AuthService) {}

  loginProcess(loginForm) {
    const data = loginForm.value
    if (data.email && data.password) {
      this.authService.auth(loginForm.value).subscribe(res => console.log(res))
    } else {
      console.log('Username dan Password Harus Diisi')
    }
  }

  ngOnInit() {}
}
