<template functional>

    <v-menu offset-y left>
        <template v-slot:activator="{on: menu}">
            <div v-on="{...menu}">
                <button-tooltip
                    icon="mdi-dots-vertical"
                    tooltip="More"
                    small
                />
            </div>
        </template>
        <v-list>
            <v-list-item
                v-for="(item, index) in props.actions"
                :key="index"
                v-show="( (typeof item.show) === 'function') ? item.show(props.resource) : item.show"
                :disabled="( (typeof item.disabled) === 'function') ? item.disabled(props.resource) : item.disabled"
                @click="item.onclick(props.resource)"
            >
                <v-list-item-title>{{ item.label }}</v-list-item-title>
            </v-list-item>
        </v-list>
    </v-menu>


</template>

<script>
export default {
    name: "TableActions",
    props: {
        resource: {  // the target resource eg user
            type: Object,
            required: true,
        },
        actions: {
            type: Array,
            required: true,
        }
    },

}
</script>

<style scoped>

</style>
