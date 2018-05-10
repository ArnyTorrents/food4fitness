import { Directive } from '@angular/core';
import {NG_VALIDATORS,Validator, AbstractControl} from '@angular/forms'

@Directive({
  selector: '[inputMinLength]',
  providers: [{provide: NG_VALIDATORS,
        useExisting: InputValidationDirective, multi: true}]
})
export class InputValidationDirective implements Validator{

  constructor() { }

  validate(formFieldToValidate: AbstractControl): {[key: string]: any} {

    let validInput: boolean = false;

    //We validate our form field accroding to our general rule
    // Control is our form filed to validate
    if(formFieldToValidate.value != undefined){
      if(formFieldToValidate.value.length > 6) {validInput = true;}
      else {validInput = false;}
    } else  {validInput = false;}

    return validInput? null:{'isNotCorrect':true};
  }
}
