<template>
    <layout-master :disable-sidebar="showSidebar" >
        <v-breadcrumbs :items="breadcrumbItems" divider=">"></v-breadcrumbs>
        <router-view></router-view>
    </layout-master>
</template>

<script>
    import LayoutMaster from "./components/layout/Master";
    import {EventBus} from "../../utils/event-bus";
    import {MessageBus} from "../../utils/message-bus";
    import LoadingEclipse from "../../utils/LoadingEclipse";

    export default {
        name: 'app',
        components: {
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
        computed: {
            showSidebar(){
                // if is in control then show
                if(this.$router.full)
                    return true;
                else
                    return false;
            }
        },
        watch: {
            '$route'(){ // make sure only the last breadcrumb link is enabled
                _.forEach(this.$route.meta.breadcrumb, function (value, index) {
                    let length = this.$route.meta.breadcrumb.length;
                    if(length -1 !== index) // if not the last item
                        this.$route.meta.breadcrumb[index].disabled = false;
                    else
                        this.$route.meta.breadcrumb[index].disabled = true;
                }.bind(this));
                this.$route.meta.breadcrumb[this.$route.meta.breadcrumb.length-1].disabled = true;
                this.breadcrumbItems = this.$route.meta.breadcrumb;
            }
        },
        methods: {


        },
        mounted(){

            MessageBus.setSession(this.session);

            // to route to the correct page if required
            let url = new URL(window.location.href);
            let routeName = url.searchParams.get("to");
            if(routeName){
                this.$router.push({
                    name: routeName
                })
            }


        }
    }
</script>

<style>
    /*#app {*/
        /*font-family: 'Avenir', Helvetica, Arial, sans-serif;*/
        /*-webkit-font-smoothing: antialiased;*/
        /*-moz-osx-font-smoothing: grayscale;*/
        /*text-align: center;*/
        /*color: #2c3e50;*/
        /*margin-top: 60px;*/
    /*}*/
</style>
