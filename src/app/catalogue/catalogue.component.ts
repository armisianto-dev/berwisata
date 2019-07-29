import { Component, OnInit } from '@angular/core'
import { Observable } from 'rxjs'
import { CatalogueList } from '../model/catalogue/catalogue-list'
import { PaginationConfig } from '../model/pagination/pagination-config'
import { CatalogueService } from '../services/catalogue/catalogue.service'

@Component({
  selector: 'app-catalogue',
  templateUrl: './catalogue.component.html',
  styleUrls: ['./catalogue.component.css'],
})
export class CatalogueComponent implements OnInit {
  showLoading: boolean = true
  currPage: number = 1
  paginationPerPage: number = 2
  paginationTotal: number = 0
  paginationConfig: PaginationConfig

  catalogueListsObservable: Observable<CatalogueList[]>

  constructor(private catalogueService: CatalogueService) {}

  onPageChange(page: number) {
    this.showLoading = true
    setTimeout(() => {
      this.catalogueListsObservable = this.catalogueService.get_all_catalogue_lists(
        page,
        this.paginationPerPage
      )
      this.catalogueListsObservable.subscribe(() => (this.showLoading = false))
    }, 1000)
  }

  ngOnInit() {
    this.currPage = 1
    this.paginationPerPage = 2

    setTimeout(() => {
      this.catalogueListsObservable = this.catalogueService.get_all_catalogue_lists(
        this.currPage,
        this.paginationPerPage
      )
      this.catalogueListsObservable.subscribe(() => (this.showLoading = false))
    }, 1000)

    this.catalogueService
      .get_catalogue_pagination()
      .subscribe((res: PaginationConfig) => {
        this.paginationTotal = res.total
      })
  }
}
