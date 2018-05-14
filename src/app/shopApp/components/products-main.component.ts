import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

//Model
import { Comanda } from "./../model/comanda";
import { Products } from './../model/products';


import { ProductDataService } from './../services/product-data.service';

@Component({
  selector: 'products-main',
  templateUrl: './../views/products-main.view.html',
  styleUrls: ['./../css/products-main.style.css'],
  providers: [ProductDataService]
})
export class ProductsMainComponent implements OnInit {

  pageTitle: string = 'Product List';
  imageWidth: number = 50;
  imageMargin: number = 2;
  showImage: boolean = false;
  listFilter: string;
  errorMessage: string;
  productDetail: Products;

  //Pagination properties
  itemsPerPage: number;
  currentPage: number;
  totalItems: number;

  //Filter properties
  nameFilter:string;
  typeFilter:string[];

  product: Products[];

  constructor(private productDataService : ProductDataService,
              private router : Router) { }

  ngOnInit() {

  }



}
