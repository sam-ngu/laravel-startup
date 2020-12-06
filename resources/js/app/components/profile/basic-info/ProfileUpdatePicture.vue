<template>

    <v-dialog max-width="500px" persistent v-model="states.show">

        <v-card>
            <v-card-title>
                <h3>
                    Select Profile Photo
                </h3>
                <v-tooltip bottom class="ml-auto">
                    <template v-slot:activator="{on}">
                        <v-btn icon v-on="on" @click="close">
                            <v-icon>clear</v-icon>
                        </v-btn>
                    </template>
                    <span>Close</span>
                </v-tooltip>

            </v-card-title>

            <v-card-text>
                <!--drag and drop area-->
                <image-uploader @image-added="addImgToData" v-model="inputData.image_raw"/>

            </v-card-text>

            <v-card-actions>
                <v-btn text @click="submit" :disabled="!inputData.image_raw" color="primary">Update</v-btn>
                <v-btn text @click="close">Cancel</v-btn>
            </v-card-actions>
        </v-card>

    </v-dialog>


</template>
<script>
    import ImageUploader from "../../../../utils/ImageUploader";
    import {swalConfirm, swalLoader, swalTimer} from "../../../../../utils/swal/SwalHelper";
    import {axiosErrorCallback} from "../../../../utils/swal/AxiosHelper";

    export default {
        name: "ProfileUpdatePicture",
        components: {ImageUploader},
        data() {
            return {
                states: {
                    show: false
                },
                inputData: {
                    image_raw: null,
                    avatar_location: null,
                },

            }
        },
        props: {

        },
        computed: {
            user(){
                return MessageBus.getSession().user;
            }
        },
        methods: {
            close(){
                this.$emit('close')
            },
            addImgToData(formData){
                this.inputData.avatar_location = formData;
            },
            submit(){
                swalConfirm("", () => {
                    swalLoader()

                    // put everything to form data
                    let form = new FormData();
                    this.inputData.avatar_location.forEach(function(ii){
                        form.append("avatar_location[]",ii);
                    });
                    form.set('avatar_type', 'storage');

                    return axios({
                            method: 'patch',
                            url: `/api/v1/users/${this.user.id}/profile`,
                            data: form,
                            headers:{
                                'content-type': "multipart/form-data",
                            }
                        })
                        .then(function (response) {
                            // EventBus.$emit('fetch-session-required');
                            swalTimer('success', 500)
                                .then(function () {
                                    this.close()
                                }.bind(this));
                        }.bind(this))
                        .catch(axiosErrorCallback)
                    }
                );
            }
        },
        mounted() {
            this.states.show = true;
            this.inputData.image_raw = this.user.avatar_location;

        },
    }
</script>

<style scoped>

</style>
