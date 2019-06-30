<style>
    #addKosmo{
        margin-top: 10px;
        display: block;
        margin-left: auto;
        margin-right: auto;
            
    }
    
    #closeBut {
        margin-top: 10px;
    }
    
    #errorNew {
        text-align: center;
        color: red;
        font-size: 125%;
        font-weight: 500;
        margin-top: 10px;
    }
    
</style>
<template>
    <div class="container" id="newKosmo">
        <h2 class="nadpis">Přidání kosmonauta</h2>
          <form @submit.prevent="sendData">
              <div class="row">  
                  <div class="col-6"><label>Jméno</label><input class="form-control" type="text" v-model="first" placeholder="Jmeno" required></div>
              <div class="col-6"><label>Přijmeni</label><input class="form-control" type="text" v-model="last" placeholder="Přijmení" required></div>
              </div>
              <div class="row">
               <div class="col-6"><label>Superschopnost</label><input class="form-control" type="text"  v-model="schopnost" placeholder="Superschopnost" required></div>
               <div class="col-6"><label>Datum narození</label><input class="form-control" type="date" v-model="birth" required></div>
              </div>  
              <div class="row">
              <button type="button" id="closeBut" class="btn btn-danger" @click="close">
                                        Zavřít
                                    </button>
              <button class="btn btn-info btn-block col-4" id="addKosmo" type="submit">Přidat kosmonauta</button>          
              </div>
              <p id="errorNew" v-show="error">{{error}}</p>
    </form>
               
  </div>
</template>

<script>
  //komponenta
  export default {
    data() {
      return {
        first: '',
        last: '',
        schopnost: '',
        birth: '',
        error: ''
      };
    },
    methods: {
        sendData() {
                this.$http.post('add', {
                    first: this.first,
                    super: this.schopnost,
                    birth: this.birth,
                    last: this.last
                }).then(() => {
                    this.error = 'Kosmonaut byl úspěšně přidán';
                    this.$parent.reloadKosmo();
                    this.$parent.sort = '';
                    this.first = '';
                    this.last = '';
                    this.schopnost = '';
                    this.birth = '';
                    this.$parent.reloadRadku();
                }, () => {
                    
                    this.error = 'Kosmonauta se nepodařilo přidat. Zkontrolujte datum narození.';
                });
            }, close(){
                this.error = '';
                this.$parent.showAdd = false;
                
            }
      
    }
  }
    
</script>

