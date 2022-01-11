<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    <Link class='btn btn-primary btn-sm' href="/events/create">
                        Create Event <i class='fa fa-plus'></i>
                    </Link>
                </div>
                <div class="float-right form-inline">
                    <label class="text-center pr-2">Showing</label>
                    <select class='form-control' v-model="event_type" @change='filterEvent'>
                        <option value=''>All Events</option>
                        <option value='up-comming'>Upcomming Events</option>
                        <option value='finished'>Finished Events</option>
                    </select>
                
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr class='bg-info'>
                            <th style="width: 10px">#</th>
                            <th>Title</th>
                            <th>Location</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for='ev of allEvent.data' :key="ev.id">
                            <td>{{ ev.id }}</td>
                            <td class="col-xs-2 text-truncate" style="max-width: 350px;" :title="ev.title">
                                <a :href='`/events/${ev.id}`'>
                                    {{ ev.title }}
                                </a>
                            </td>
                            <td>{{ ev.location ? ev.location.name : '-' }}</td>
                            <td class="text-nowrap">{{ ev.start_date }}</td>
                            <td class="text-nowrap">{{ ev.end_date }}</td>
                            <td v-html="ev.event_status"></td>
                            <td>
                                {{ ev.user ? ev.user.name :'-' }}
                            </td>
                            <td>
                                <Link :href='`/events/${ev.id}/edit`'>
                                <i class='fa fa-edit text-blue'></i>
                                </Link>
                                <a @click.prevent='destroy(ev.id)' href="#">
                                    <i class='fa fa-trash text-danger'></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <!-- <div class="card-footer clearfix">
		
	</div> -->
        </div>
        <pagination :data="allEvent" @pagination-change-page="getResults" />
    </div>
</template>
<script type="text/javascript">
const urlParams = new URLSearchParams(window.location.search);
import { Inertia } from '@inertiajs/inertia';
export default {
    props: ['events'],
    data() {
        return {
            allEvent: this.events,
            event_type: urlParams.get('type') || '',
        }
    },

    methods: {
        filterEvent() {
            location.href = `/events?type=${this.event_type}`;
        },
        getResults(page) {
            if (typeof page === 'undefined') {
                page = 1;
            }
            let url = '/events?page=' + page + `&type=${this.event_type}`;
            Inertia.visit(url, { preserveScroll: true });

        },
        destroy(id) {
            const deleteIt = () => {
                axios.delete(`/events/${id}`, {
                    data: {
                        _token: this.$page.props.csrf_token,
                    }
                }).then(() => {
                    this.allEvent = {
                        ...{
                            data: this.allEvent.data.filter((value) => value.id != id)
                        }
                    }
                    this.toastAlert.fire({
                        icon: 'success',
                        title: 'Successfully deleted'
                    })
                }).catch(err => {
                    alert(err);
                })

            }

            if (typeof Swal !== undefined) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteIt();
                    }
                });
            } else {
                deleteIt();
            }
        }
    }
}

</script>
