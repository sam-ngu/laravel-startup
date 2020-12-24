<template>
    <div>
        <layout-master :disable-sidebar="false" >
            <v-breadcrumbs :items="breadcrumbItems" divider=">"></v-breadcrumbs>
            <router-view></router-view>
        </layout-master>
        <confirm-password-dialog/>
    </div>

</template>

<script>
import LayoutMaster from "./containers/layout/LayoutMaster";
import LoadingEclipse from "../partials/LoadingEclipse";
import ConfirmPasswordDialog from "../partials/auth/ConfirmPasswordDialog";


export default {
    name: 'BaseApp',
    components: {
        ConfirmPasswordDialog,
        LoadingEclipse,
        LayoutMaster,
    },
    data(){
        return{
            breadcrumbItems : this.$route.meta.breadcrumb,
        }
    },
    props: {
        session: { // json string contains the current session info
            type: String,
            required : true,
        }
    },

    watch: {
        '$route'(){
            _.forEach(this.$route.meta.breadcrumb, function (value, index) {
                let length = this.$route.meta.breadcrumb.length;
                this.$route.meta.breadcrumb[index].disabled = length - 1 === index;
            }.bind(this));
            this.$route.meta.breadcrumb[this.$route.meta.breadcrumb.length-1].disabled = true;
            this.breadcrumbItems = this.$route.meta.breadcrumb;
        }
    },
    mounted(){

        // to route to the correct page if required
        let url = new URL(window.location.href);
        let routeName = url.searchParams.get("to");
        if(routeName){
            this.$router.push({
                name: routeName
            })
        }
        const session = JSON.parse(this.session) || {};

        this.$store.commit('auth/setSession', session);
    }
}
</script>

<style>
</style>
