<template >

    <article>
        <span v-if="mode === 'read'">{{ value }}</span>
        <!--        edit mode  -->


        <v-menu
            v-else
            ref="menu1"
            v-model="states.showMenu"
            :close-on-content-click="false"
            transition="scale-transition"
            offset-y
            max-width="290px"
            min-width="290px"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-text-field
                    :value="value"
                    label="Date"
                    hint="YYYY-MM-DD format"
                    persistent-hint
                    prepend-icon="mdi-event"
                    v-bind="attrs"
                    @blur="date = parseDate(value)"
                    v-on="on"
                ></v-text-field>
            </template>

            <v-date-picker
                no-title
                @input="datePicked"
                :value="date"
            />
        </v-menu>
    </article>

</template>

<script>
export default {
    name: "DateField",
    data(){
        return {
            states: {
                showMenu: false,
            },
            date: '',
        }
    },
    props: {
        mode: {
            type: String,
            default: 'read', // can be write or read
        },
        value: '',
    },
    watch: {
        date (val) {
            this.$emit('input', this.formatDate(this.date))
        },
    },
    methods: {
        datePicked(date){
            this.states.showMenu = false
            this.date = date
        },
        formatDate (date) {
            if (!date) return null

            const [year, month, day] = date.split('-')
            return `${year}-${month}-${day}`
        },
        parseDate (date) {
            if (!date) return null

            const [month, day, year] = date.split('-')
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
        },
    }

}
</script>

<style scoped>

</style>
