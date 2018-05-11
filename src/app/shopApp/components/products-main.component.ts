import { Component, OnInit } from '@angular/core';

import { Products } from './../model/products'

@Component({
  selector: 'app-products-main',
  templateUrl: './../views/products-main.view.html',
  styleUrls: ['./../css/products-main.style.css']
})
export class ProductsMainComponent implements OnInit {

  pageTitle: string = 'Product List';
  imageWidth: number = 50;
  imageMargin: number = 2;
  showImage: boolean = false;
  listFilter: string;
  errorMessage: string;

  product: Products[];

  constructor() { }

  ngOnInit() {
  }


}
