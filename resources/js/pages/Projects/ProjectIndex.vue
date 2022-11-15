<template>

    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <div class="d-flex justify-content-between mb-2">
            <h6 class="border-bottom pb-2 mb-0">Projects</h6>
            <router-link :to="{name: 'projects_add'}" class="btn btn-primary btn-sm">Add New</router-link>
        </div>
        <Vue3EasyDataTable
            v-model:server-options="serverOptions"
            :server-items-length="serverItemsLength"
            :headers="headers"
            :items="projects"
            :loading="busy"
            show-index
        >
            <template #loading>
                <img
                    src="https://i.pinimg.com/originals/94/fd/2b/94fd2bf50097ade743220761f41693d5.gif"
                    style="width: 100px; height: 80px;"
                />
            </template>
        </Vue3EasyDataTable>
    </div>
</template>

<script>
import axios from "axios";
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';

export default {
    name: "Projects",
    components: {
        Vue3EasyDataTable,
    },
    data() {
        return {
            headers: [
                {text: "Workspace", value: "workspace.name"},
                {text: "Project name", value: "name"},
                {text: "Status", value: "owner_status"},
                {text: "Members", value: "members.length"},
                {text: "Tasks", value: "tasks_count"},
            ],
            projects: [],
            busy: false,
            serverItemsLength: false,
            serverOptions: {
                page: 1,
                rowsPerPage: 15,
            }
        }
    },
    watch: {
        serverOptions: {
            handler() {
                this.getProjects()
            },
            deep: true
        }
    },
    mounted() {
        this.getProjects()
    },
    methods: {
        async getProjects() {
            try {
                this.busy = true
                await axios.get('/api/v1/projects', { params: this.serverOptions })
                    .then(({data}) => {
                        console.log(data.data)
                        this.projects = data.data.data
                        // this.serverOptions = data.data.meta
                        this.serverItemsLength = data.data.meta.total
                    }).catch((err) => {
                        throw err.response
                    });
                this.busy = false
            } catch (e) {
                throw e
            }
        }
    },
}
</script>

<style scoped>

</style>
