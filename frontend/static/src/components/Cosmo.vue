<style>
    .nadpis {
        text-align: center;
        padding-top:  1em;
        margin-bottom: 0.5em;
        color: brown;
    }
    
    body {
        background-image: url('../media/back.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        min-height: 100vh;
        
    }
    
    #page {
        padding: 0;
        background-color: lightcyan;
        opacity: 1;
    }
    
    .table {
        margin-bottom: 2em;
    }
    
    .table-striped tbody tr:nth-of-type(2n+1) {
    background-color: rgba(0, 0, 200, 0.08);
}
    .modal-wrapper {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    background-color: rgba(0, 0, 0, 0.7);
    background-size: cover;    
}

    .modal-container {
  width: 550px;
  margin: auto auto;
  padding: 20px 25px 20px 0;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
  transition: all .3s ease;
  font-family: Helvetica, Arial, sans-serif;
  z-index: 100;
  position: absolute;
  top: 40vh;
  left: 35vw;
      
}

    .modalBackground {
    width: 100vw;
    height: 100vh;
    overflow-x: hidden;
    overflow-y: hidden;
}

    .MainForm{
        text-align: right;
        position: relative;
        left:  40%;   
}
    #mainMenu {
        margin-top: 2em;
}
    #labelNajit {
        color: brown;
        font-size: 120%;
        font-weight: 500;
}
    .tableBtn {
        color: darkblue;
        border: none;
        font-weight: bold;
        vertical-align: bottom;
        padding: 0;
        background: none;
}
  

    .tableBtn:hover {
        background: none;
        color: gray;
}
      .icon {
        width: 25px;
        margin: 0;
        padding: 0;
}

    .hiden {
        visibility: hidden;
}

    
    #mainBlock {
        min-height: 93vh;
        padding-bottom: 2em;
}

    tr {
       cursor: pointer;
}
    tr:hover {
        background-color: rgba(0, 0, 50, 0.08);
}

    .table-striped tbody tr:nth-of-type(2n+1):hover {
        background-color: rgba(0, 0, 50, 0.08);
}
    

    #headTable {
        cursor: default;
} 
    #headTable:hover {
        background: none;
}

    .labelMain {
        color: #444444;
        
}

    .mobileVypis  {
        display: none;
}

    @media screen and (max-width: 800px) and (min-width: 650px) {
        #page {
            max-width: 100vw;
            
        }
        
        .MainForm {
            position: relative;
            left: 10%;
        }
        
        .modal-container {
            position: absolute;
            top: 15vh;
            left: 1vh;
            width: 98vw;
        }      
        
        
    }
    
        
    
    @media screen and (max-width: 650px) {
        #labelNajit{
            text-align: left;
        }
        
         #page {
            max-width: 100vw;
            
        }
        
        .MainForm {
            position: relative;
            left: 10%;
        }
        
        .modal-container {
            position: absolute;
            top: 15vh;
            left: 1vh;
            width: 98vw;
        }  
        
        .mobileVypis {
            display: block;
            border: 1px solid lightblue;
            border-radius: 10px;
            background: white;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
            box-shadow: 2px 2px  3px 3px #888888;
        }
        
        .table-striped {
            display: none;
        }
        
        .btnBox {
            margin-left: 5em;
         
        }
    }
        
        
        
    

      
</style>
<template>
    <div class="container" v-bind:class="{modalBackground: showModal}" id="page">
    <div id="mainBlock">
                <hlavicka></hlavicka>
    <div class="container"  >
        <modal v-if="showModal" @close="showModal = false">
    <!--
      you can use custom content here to overwrite
      default content
    -->
         
    
        </modal>
        
        
        <add-cosmo v-if="showAdd" v-bind:class="{hiden: showModal}"></add-cosmo>
        
        <div class="row container" v-if="!(showAdd)" v-bind:class="{hiden: showModal}" id="mainMenu">
            <button class="btn btn-primary btn-block col-3" @click="showAdd = true">Nový záznam</button>
            <form class="form-inline my-2 my-lg-0 MainForm">
                <label class='col' id='labelNajit'>Najít:</label> <input class="form-control mr-sm-2" type="search" placeholder="Najít" v-model="filter" aria-label="Search">
      
    </form></div>
        <h1 class="nadpis">Výpis kosmonautů</h1>
        <table class="table table-striped">
            <thead>
            <tr id="headTable">
                <th scope="col" >Jméno</th><th scope="col" >
                    <button @click="sortKosmo('prijmeni')" class=" tableBtn ">Přijmení <v-icon v-if="sort == 'prijmeni' " name="chevron-up"></v-icon>  <v-icon v-if="sort == 'prijmeni DESC' " name="chevron-down"></v-icon></button></th>
                <th scope="col" ><button @click="sortKosmo('superschopnost')" class="tableBtn">Superschopnost <v-icon v-if="sort == 'superschopnost' " name="chevron-up"></v-icon><v-icon v-if="sort == 'superschopnost DESC' " name="chevron-down"></v-icon></button></th>
                <th scope="col" ><button @click="sortKosmo('vek')" class="tableBtn">Věk <v-icon v-if="sort == 'vek' " name="chevron-down"></v-icon><v-icon v-if="sort == 'vek DESC' " name="chevron-up"></v-icon></button></th>
            </tr>
            </thead>
            <tbody v-if="filter == ''">
            <tr v-for="kosmonaut in kosmo"  scope="row" @click="editovat( kosmonaut.idCosmo )">
            <td>
                   {{kosmonaut.jmeno}}
            </td>
            <td>
                {{kosmonaut.prijmeni}}
            </td>  
            <td>
                {{kosmonaut.superschopnost}}
            </td>  
            <td>
                {{kosmonaut.vek}}
            </td>  
            
            <td>
                <button @click="editovat( kosmonaut.idCosmo )"  type="button" class="btn btn-info btnTable" >Editovat</button>
            </td> 
        </tr>
        
            </tbody>
            <tbody v-else>
            <tr v-for="kosmonaut in kosmo" v-if='kosmonaut.jmeno.toLowerCase().includes(filter.toLowerCase())  || kosmonaut.prijmeni.toLowerCase().includes(filter.toLowerCase()) || kosmonaut.superschopnost.toLowerCase().includes(filter.toLowerCase())' scope="row">
            <td >
                   {{kosmonaut.jmeno}}
            </td>
            <td>
                {{kosmonaut.prijmeni}}
            </td>  
            <td>
                {{kosmonaut.superschopnost}}
            </td>  
            <td>
                {{kosmonaut.vek}}
            </td>  
            
            <td>
                <button @click="editovat( kosmonaut.idCosmo )"  type="button" class="btn btn-info btnTable" >Editovat</button>
            </td> 
        </tr>
        
            </tbody>
        </table>
        
        
        <div class="container mobileVypis" v-if="filter == ''"  v-for="kosmonaut in kosmo" @click="editovat( kosmonaut.idCosmo )">
          
            <div class="row"><label class="col-3 labelMain" style="text-align:right">Jmeno:</label><div class="col" >{{kosmonaut.jmeno}}</div><label class="col-2 labelMain">Věk:</label><div class="col"> {{kosmonaut.vek}} </div></div>
               
          
            <div class="row"> <label class="col-3 labelMain" style="text-align:right"">Příjmení:</label> <div class="col">{{kosmonaut.prijmeni}}</div></div>
            <div class="row"> <label class="col labelMain">Superschopnost:</label>   <div class="col"> {{kosmonaut.superschopnost}} </div></div>
                      
            <button @click="editovat( kosmonaut.idCosmo )"  type="button" class="btn btn-info btnBox" >Editovat</button>
        </div> 
        
        <div v-else >
        <div class="container mobileVypis" v-for="kosmonaut in kosmo" v-if='kosmonaut.jmeno.toLowerCase().includes(filter.toLowerCase())  || kosmonaut.prijmeni.toLowerCase().includes(filter.toLowerCase()) || kosmonaut.superschopnost.toLowerCase().includes(filter.toLowerCase())' @click="editovat( kosmonaut.idCosmo )">
                    
            <div class="row"><label class="col-3 labelMain" style="text-align:right">Jmeno:</label><div class="col" >{{kosmonaut.jmeno}}</div><label class="col-2 labelMain">Věk:</label><div class="col"> {{kosmonaut.vek}} </div></div>
               
          
            <div class="row"> <label class="col-3 labelMain" style="text-align:right">Příjmení:</label> <div class="col">{{kosmonaut.prijmeni}}</div></div>
            <div class="row"> <label class="col labelMain">Superschopnost:</label>   <div class="col"> {{kosmonaut.superschopnost}} </div></div>
        
           
                      
            <button @click="editovat( kosmonaut.idCosmo )"  type="button" class="btn btn-info btnBox" >Editovat</button>
        </div> 
        </div>
        <button @click="prevPage() " v-if="vypisOd !== 0" class="btn btn-outline-primary" style="text-align: left;">&lsaquo;&lsaquo; Předcházejíci záznamy</button>
        <button @click="nextPage() " v-show="(vypisOd + 20) < radku" class="btn btn-outline-primary" style="float: right;">Následují záznamy &rsaquo;&rsaquo;</button> 
        
    </div>
    </div>
    <patka></patka>
    </div>
</template>

<script>
   import Modal from './CosmoDetail';
   import Novy from './New';
   import Patka from './Paticka';
   import Hlavicka from './Header';
    export default {
        data() {
            return {
                kosmo: [],
                showModal: false,
                showAdd: false,
                id: '',
                filter: '',
                sort: '',
                radku: 0, 
                vypisOd: 0
                
            };
        },
        mounted() {
            this.reloadKosmo();
            this.reloadRadku();
        },
        methods: {
            reloadKosmo() {
                this.$http.get('kosmonauti/' + this.vypisOd).then((response) => {
                    this.kosmo = response.data;
                });
            }, editovat(id) {
                this.id = id;
                this.showModal = true;
            }, sortKosmo(sortBy ) {
                this.vypisOd = 0;
                let rank = '';
                if (this.sort == sortBy) {
                   this.sort = sortBy + " DESC";
                    rank = 'DESC';
                } else {
                    this.sort = sortBy;
                    rank ='ASC';
                }
                this.$http.get('kosmonauti/' + sortBy + '/' + rank + '/' + this.vypisOd).then((response) => {
                    this.kosmo = response.data;
                });
            }, reloadRadku(id) {
                this.$http.get('rows').then((response) => {
                    this.radku = response.data.radku;
                   
                });
            }, nextPage() {
                this.vypisOd += 20;
                this.reloadKosmo(); 
            }, prevPage() {
                this.vypisOd -= 20;
                this.reloadKosmo(); 
            }
        }, updated() {
            },
        components: {
               'modal': Modal,
               'add-cosmo': Novy,
               'patka': Patka,
               'hlavicka': Hlavicka
               
        }
    }
</script>
