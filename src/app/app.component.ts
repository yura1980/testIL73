import {Component, OnInit} from '@angular/core';
import {HttpService} from './http.service';
import {PrimeNGConfig} from 'primeng/api';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = 'ООО "ИЛ 73"';
  bid: any;
  optionsPol: any[];
  id: string;

  constructor(public service: HttpService, private config: PrimeNGConfig) {
    this.optionsPol = [
      {name: 'Мужской', code: '0'},
      {name: 'Женский', code: '1'}];
    this.bid = {fam: '', name: '', otch: '', pol: {name: 'Мужской', code: '0'}, dr: null, weight: null, height: null};
  }

  ngOnInit() {
    this.config.setTranslation({
      // accept: 'Accept',
      // reject: 'Cancel',
      // firstDayOfWeek: 1,
      dayNames: ['Вск', 'Под', 'Втр', 'Срд', 'Четв', 'Птн', 'Суб'],
      dayNamesShort: ['вс', 'пн', 'в', 'ср', 'чт', 'пт', 'сб'],
      dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
      monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь',
        'Октябрь', 'Ноябрь', 'Декабрь'],
      monthNamesShort: ['янв', 'фев', 'мат', 'апр', 'май', 'июнь', 'июль', 'авг', 'сен', 'окт', 'нояб', 'дек'],
      today: 'Сегодня',
      clear: 'Очистить'
    });
  }

  // загрузить файл
  load() {
    location.href = 'http://medosmotr-plus.ru/wwwphpword/index.php/' + this.id;
  }

  // сохранить заявку в БД
  save() {
    const val = Object.assign({}, this.bid);
    val.pol = val.pol.code;
    val.dr = this.service.GD(val.dr);
    this.service.postDataId('test_il73', val).subscribe((data: any) => {
      this.id = data;
    });
  }
}
