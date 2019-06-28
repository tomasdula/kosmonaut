<style>
    .popis {
        text-align: right;
        
    }
    
    #buttonGroup {
        text-align: center;
    }
    
    .btn-danger:hover, .btn-success:hover {
        color: black;
    }
   
    .btn-warning:hover {
        color: white;
    }
    
    #buttonGroup {
        padding-left: 2em;
    }
    
    .inputDetail {
        margin-top: 2px;
        margin-bottom: 2px;
    }
    
    #errorEdit {
        text-align: center;
        color: red;
        font-size: 110%;
        font-weight: 500;
        margin-top: 5px;
    }
    
</style>
<template>
    <div id="modal-template">
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">

                        <div class="modal-body">
                            <slot name="body">
                                
                               
                        <div class="row inputDetail"><label class="col-4 popis" >Jméno:</label><input class="form-control col-8" type="text" v-model="kosmonaut.jmeno"  required></div>
                        <div class="row inputDetail" ><label class="col-4 popis" >Přijmeni</label><input class="form-control col-8" type="text" v-model="kosmonaut.prijmeni"  required></div>              
                         <div class="row inputDetail"><label class="col-4 popis" >Superschopnost</label><input class="form-control col-8" type="text" v-model="kosmonaut.superschopnost"  required></div>
                        <div class="row inputDetail"><label class="col-4 popis" >Datum narození</label><input class="form-control col-8" type="date" v-model="kosmonaut.datum_narozeni" required></div>
                            <p id="errorEdit" v-show="error">{{error}}</p>
                            </slot>
                        </div>

                        <div>
                            <slot name="footer">
                                <div id="buttonGroup" class="col">
                                    <button type="button" class="btn btn-warning" @click="updateKosmo">Změnit</button>
                                    <button type="button" class="btn btn-danger " @click="deleteKosmo">Smazat</button>
                                    <button type="button" class="btn btn-success" @click="$emit('close')">
                                        Zavřít
                                    </button>
                                </div>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    //komponenta
    export default {
    data() {
    return {
        kosmonaut: [],
        error: ''
    };
    },
            methods: {
                deleteKosmo() {
                    this.$http.post('del' , {
                    id: this.$parent.id
                    
                }).then(() => {
                        this.$parent.reloadKosmo();
                        this.$parent.showModal = false;
                        this.$parent.id = '';  
                        this.$parent.sort = '';
                        alert('Kosmonaut byl úspěšně odebrán');
                        
                    }, () => {
                        alert('Kosmonauta se nepodařilo odebrat');
                    });
                }, loadKosmo() {
                    this.$http.get('kosmonaut/' + this.$parent.id).then((response) => {
                    this.kosmonaut = response.data;
                });
                }, updateKosmo() {
                    this.$http.put('kosmo/' + this.$parent.id, {
                    first: this.kosmonaut.jmeno,
                    last: this.kosmonaut.prijmeni,
                    birth: this.kosmonaut.datum_narozeni,
                    super: this.kosmonaut.superschopnost
                }).then(() => {
                    this.$parent.reloadKosmo();
                    this.$parent.sort = '';
                    this.kosmonaut = [];
                                        alert('Kosmonaut byl úspěšně aktualizován');

                    this.$parent.showModal = false;
                }, () => {
                    this.error = 'Kosmonauta se nepodrilo aktualizovat. Zkontrolujte udaje.';
                });
                }
            }, mounted() {
                this.loadKosmo();
            }
           
    }

</script>
