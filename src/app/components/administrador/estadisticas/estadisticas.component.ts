import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup } from '@angular/forms';
import { AdministradorService } from 'src/app/services/administrador/administrador.service';

@Component({
  selector: 'app-estadisticas',
  templateUrl: './estadisticas.component.html',
  styleUrls: ['./estadisticas.component.css']
})
export class EstadisticasComponent implements OnInit {
  formEstadisticas:FormGroup;
  programas:any;
  estadisticas:any;
  siEstadisticasObtenidas:boolean = false;

  multi = [
    {
      "name": "LIS",
      "series": [
        {
          "name": "2010",
          "value": 7300000
        },
        {
          "name": "2011",
          "value": 8940000
        }
      ]
    },
  
    {
      "name": "LCC",
      "series": [
        {
          "name": "2010",
          "value": 7870000
        },
        {
          "name": "2011",
          "value": 8270000
        }
      ]
    },
  
    {
      "name": "LM",
      "series": [
        {
          "name": "2010",
          "value": 5000002
        },
        {
          "name": "2011",
          "value": 5800000
        }
      ]
    }
  ];

  // options
  showXAxis: boolean = true;
  showYAxis: boolean = true;
  gradient: boolean = false;
  showLegend: boolean = true;
  legendPosition: string = 'below';
  showXAxisLabel: boolean = true;
  yAxisLabel: string = 'Licenciatura';
  showYAxisLabel: boolean = true;
  xAxisLabel = 'Cantidad';
  colorScheme = {
    domain: ['#C68D2A']
  };
  schemeType: string = 'linear';

  constructor(private servicioAdmin:AdministradorService, private formBuilder:FormBuilder) { }

  ngOnInit(): void {
    this.formEstadisticas = this.formBuilder.group({
      tipo:[""],
      genero:[""],
      fechaInicio:[""],
      fechaFin:[""],
      programa:[""],
      NombrePlan:[""],
      ClavePlan:[""]
    });
    this.obtenerProgramas();
  }

  obtenerEstadisticas(){
    this.siEstadisticasObtenidas = false;
    this.formEstadisticas.controls["NombrePlan"].setValue(this.programas[this.formEstadisticas.controls["programa"].value].NombrePlan);
    this.formEstadisticas.controls["ClavePlan"].setValue(this.programas[this.formEstadisticas.controls["programa"].value].ClavePlan);
    this.servicioAdmin.obtenerEstadisticas(this.formEstadisticas.value).subscribe(
      respuesta=>{
        console.log(respuesta);
        this.estadisticas = respuesta;
        this.siEstadisticasObtenidas = true;
      },
      error=>{
        alert("Ocurrió un error al obtener las estadísticas")
      }
    );
  }

  obtenerProgramas(){
    this.servicioAdmin.obtenerProgramas().subscribe(
      respuesta=>{
        this.programas = respuesta;
      }
    );
  }

  onActivate(event){

  }

  onDeactivate(event){

  }

  onSelect(event){

  }
}