<template>
    <div>
        
            
            <v-dialog v-model="dialog" persistent max-width="600px">
                
                <v-card>
              <v-card-title style="background-color:#668c2d">
                        <span class="headline" style="color:#fff">Recordatorio</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <v-flex xs12 sm12 md12>
                                    Desea cerrar caja?
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <template v-if="error">
                        <v-divider></v-divider>
                        <div class="text-xs-center">
                            <strong class="red--text text--lighten-1" v-for="e in errorMsj" :key="e" v-text="e"></strong>
                            <br>
                        </div>
                        <v-divider></v-divider>
                    </template>
                    <v-card-actions>
                         <div class="flex-grow-1"></div>

                            <v-btn color="green darken-1" text @click="dialog = false">
                                Disagree
                            </v-btn>

                            <v-btn color="green darken-1" text @click="menu = !menu">
                                Agree
                            </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        
        
    </div>
</template>
<script>
    export default {
        data: () => ({
            search: '',
            dialog: false,
            error: '',
            menu:21,
            inicio: false,
            errorMsj: [],
            
        }),
      
        watch: {
            dialog(val) {
                val || this.close()
            }
        },
        created() {
            this.initialize();

        },
        mounted(){
            let me = this;
            this.dialog = true
            
        },
        methods: {
            validate() {
                let me = this;
                this.error = 0;
                this.errorMsj = [];
                if (this.errorMsj.length)
                    this.error = 1;
                return this.error;
            },

            close() {
                this.error=0;
                this.dialog = false;
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                }, 300)
            },
        }
    }
</script>
<style lang="scss">
    @import '~vuetify/dist/vuetify.min.css';
</style>