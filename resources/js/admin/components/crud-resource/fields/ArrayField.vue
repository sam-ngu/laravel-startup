<template functional>

    <article>
        <div v-if="props.mode === 'read'">
            <v-chip
                v-for="(val, index) in props.value"
                :key="val[props.itemValue]"
                color="primary"
                label
                v-bind="{...props.$attrs}"
            >
                {{ val[props.itemText] }}
            </v-chip>
        </div>
        <!--        edit mode  -->
        <v-combobox
            v-else
            @input="listeners.input"
            :filter="filter"
            :value="value"
            hide-no-data
            hide-selected
            multiple
            deletable-chips
            small-chips
            solo
        />

    </article>
</template>

<script>
export default {
    name: "ArrayField",
    props: {
        mode: {
            type: String,
            default: 'read', // can be write or read
        },
        rules: {
            type: Array,
            default: () => []
        },
        value: '',
        itemText: {  // the foreign resource property to show in dropdown
            type: String,
            default: 'id',
        },
        itemValue: {
            type: String,
            default: 'id',
        },
    },

}
</script>

<style scoped>

</style>
