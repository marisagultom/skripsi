                <table class="table">
                <tr>
                    <th>Nama task</th>
                    <th>Deskripsi</th>
                    <th>Ditugaskan kepada</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                    <?php
                        if (count($tasks) > 0) {
                            foreach ($tasks as $task) { ?>
                                <tr>
                                    <td><?php echo $task->activity ? $task->activity : ''; ?></td>
                                    <td><?php echo $task->description ? $task->description : ''; ?></td>
                                    <td><?php echo $task->assignedTo && $task->assignedTo->fullname ? $task->assignedTo->fullname : ''; ?></td>
                                    <td><?php echo $task->deadline_datetime ? $task->deadline_datetime : ''; ?></td>
                                    <td><label class="green" style="<?php echo $task->status == "done" ? "color: white; background-color: forestgreen;" : ''; ?>"><?php echo $task->status; ?></label></td>
                                    <td>
                                        <a title="delete" align="right" class="" href='{!! url('/delete-task/'.$task->id); !!}'><img src="{{ url('/image/icon-delete.jpg') }}" height="30px" width="30px"> </a>
                                        <a class="btn btn-primary" href='{!! url('/change-status-task/'.$task->id); !!}'> <?php echo $task->status == "active" ? "Done" : "Undone" ?> </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="5">
                                    <center>(no data)</center>
                                </td>
                            </tr>
                        <?php } ?>
                </table>