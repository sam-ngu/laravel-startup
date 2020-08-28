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
        const basePath = this.$route.fullPath;  // this is something like /auth/user

        const routes = [
            {
                path: basePath,
                component: BaseTable,
                name: this.resourceName.toLowerCase() + '-table',
                meta: {
                    breadcrumb: baseBreadcrumb,
                },
            },
            {
                path: basePath + '/create',
                component: BaseCreate,
                name: this.resourceName.toLowerCase() + '-create',
                meta: {
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
                    breadcrumb: baseBreadcrumb.concat([
                        {
                            text: `Update`,
                            disabled: true,
                            href: '',
                        }
                    ]),
                },
            },

        ]
        this.$router.addRoutes(routes);

    },
}
</script>

<style scoped>

</style>
