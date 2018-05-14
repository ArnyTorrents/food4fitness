import { Component, OnInit } from '@angular/core';

import { Router } from '@angular/router';

import { Comanda } from "./../model/comanda";

import { Products } from './../model/products';

import { ProductDataService } from './../services/product-data.service';

@Component({
  selector: 'product-managment',
  templateUrl: './../views/product-managment.view.html',
  styleUrls: ['./../css/product-managment.style.css'],
  providers: [ProductDataService]

})
export class ProductManagmentComponent implements OnInit {

  //properties
  productAction: number;
  productsType : ProductsType[]=[];

  product: Products[];

  constructor() { }

  ngOnInit() {
  }

}
