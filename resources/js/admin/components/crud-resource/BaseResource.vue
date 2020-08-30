<template>

    <section>
        <router-view/>

    <!--  TODO:  account for create, table and update-->
<!--        <article v-for="(field, index) in fields" :key="field.label">-->
<!--            <component-->
<!--                :is="resolveFieldComponent(field.type)"-->
<!--                :label="field.label"-->
<!--            />-->
<!--        </article>-->

    </section>
</template>

<script>

import BaseTable from "./table/BaseTable";
import BaseCreate from "./create/BaseCreate";
import BaseUpdate from "./update/BaseUpdate";
import resourceStore from './resource-store';

export default {
    name: "BaseResource",
    data() {
        return {}
    },
    props: {
        fields: {
            // an array of object
            // {
            //     label:
            //     type:
            //     hideOnCreate:
            //     hideOnUpdate:
            // }
            type: Array,
            default: [],
        },
        resourceName: {
            type: String,
            required: true,
        },
        resourceUrl: {
            type: String,
            required: true,
        }

    },
    computed: {},
    methods: {
        resolveFieldComponent(type){
            return (type instanceof Function) ? type() : type;
        }
    },
    created() {
        const baseBreadcrumb = this.$route.meta.breadcrumb;
        const resourceName = this.resourceName.toLowerCase();
        const matchedPath = this.$router.resolve({name: `${resourceName}-management`}).resolved.matched[0];
        const basePath = matchedPath.path.slice(0, -2) ;  // this is something like /auth/user

        const routes = [
            {
                path: basePath + '/manage',
                component: BaseTable,
                name: this.resourceName.toLowerCase() + '-table',
                meta: {
                    resourceName,
                    breadcrumb: baseBreadcrumb,
                },
            },
            {
                path: basePath + '/create',
                component: BaseCreate,
                name: this.resourceName.toLowerCase() + '-create',
                meta: {
                    resourceName,
                    breadcrumb: baseBreadcrumb.concat([
                        {
                            text: `Create`,
                            disabled: true,
                            href: '',
                        }
                    ]),
                },
            },
            {
                path: basePath + '/update/:id',
                component: BaseUpdate,
                name: this.resourceName.toLowerCase() + '-update',
                meta: {
                    resourceName,
                    breadcrumb: baseBreadcrumb.concat([
                        {
                            text: `Update`,
                            disabled: true,
                            href: '',
                        }
                    ]),
                },
            },
        ];

        const resolved = this.$router.resolve({name: resourceName + '-table'}).resolved;

        if(resolved.matched.length < 1){
            // add the routes as children
            const found = this.$router.options.routes.find(route => {
                return route.name === resourceName + '-management';
            });
            found.children = routes;
            // FIXME: as of 29th Aug 2020, it is not possible to add child routes to an existing route
            // waiting for Vue router 4
            this.$router.addRoutes([found]);
        }

        // to force update the router so newly added routes will show
        this.$router.push({name: resourceName + '-table'});

        if(!this.$store.hasModule(`${resourceName}Management`)){
            this.$store.registerModule(`${resourceName}Management`, resourceStore);
        }
        this.$store.commit(`${resourceName}Management/setFields`, this.fields);
        this.$store.commit(`${resourceName}Management/setResourceName`, resourceName);
        this.$store.commit(`${resourceName}Management/setResourceUrl`, this.resourceUrl);
    },
}
</script>

<style scoped>

</style>
