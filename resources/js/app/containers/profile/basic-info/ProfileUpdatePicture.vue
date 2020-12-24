<template>

    <v-dialog max-width="500px" persistent v-model="states.show">

        <v-card >
            <v-card-title>
                <h3>
                    Select Profile Photo
                </h3>

                <div class="ml-auto">
                    <button-tooltip
                        icon="mdi-close"
                        tooltip="Close"
                        @click="close"
                    />
                </div>

            </v-card-title>

            <v-card-text style="min-height: 200px">
                <!--drag and drop area-->
                <image-uploader v-if="!states.isLoading" @image-added="addImgToData" v-model="inputData.image_raw"/>
                <base-loader v-else/>

            </v-card-text>

            <v-card-actions>
                <v-btn text @click="submit" :disabled="!inputData.image_raw" color="primary">Update</v-btn>
                <v-btn text @click="close">Cancel</v-btn>
            </v-card-actions>
        </v-card>

    </v-dialog>


</template>
<script>
import ImageUploader from "../../../../partials/ImageUploader";
import {swalConfirm, swalLoader, swalTimer} from "../../../../utils/swal/SwalHelper";
import {axiosErrorCallback} from "../../../../utils/swal/AxiosHelper";
import ButtonTooltip from "../../../../partials/ButtonTooltip";
import {useAuthStore} from "../../../store/auth-store";
import BaseLoader from "../../../../admin/components/crud-resource/partials/BaseLoader";

const {getUser, setUser} = useAuthStore();

export default {
    name: "ProfileUpdatePicture",
    components: {BaseLoader, ButtonTooltip, ImageUploader},
    data() {
        return {
            states: {
                show: false,
                isLoading: false,
            },
            inputData: {
                image_raw: null,
                avatar_location: null,
            },
        }
    },
    props: {},
    computed: {
        user() {
            return getUser();
        }
    },
    methods: {
        close() {
            this.$emit('close')
        },
        addImgToData(formData) {
            this.inputData.avatar_location = formData;
        },
        submit() {
            this.states.isLoading = true;

            // put everything to form data
            let form = new FormData();
            this.inputData.avatar_location.forEach(function (ii) {
                form.append("avatar_img", ii);
            });
            form.set('avatar_type', 'storage');

            return axios({
                method: 'patch',
                url: `/api/v1/users/${this.user.id}/profile/picture`,
                data: form,
                headers: {
                    'content-type': "multipart/form-data",
                }
            })
                .then(function (response) {
                    this.states.isLoading = false;
                    setUser({
                        ...getUser(),
                        avatar_location: response.data.data.avatar_location,
                    })
                    this.close();
                }.bind(this))
                .catch(axiosErrorCallback)

            // swalConfirm("", () => {
            //     swalLoader()
            //
            //     }
            // );
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
