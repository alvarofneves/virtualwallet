<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="department in departments"  :key="department.id">
                    <td>{{ department.name }}</td>
                    <td>{{ department.date }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data:function(){
        return {
            title: 'List Departments' ,
            departments:[]
        }
    },
    async created(){
        this.departments = (await axios.get('api/departments')).data.data
    },
}
</script>

<style>

</style>

