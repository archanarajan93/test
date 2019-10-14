<div class="box no-border no-padding">
    <div class="box-body no-padding">
       <table class="table table-results">
           <tbody>
               <tr>
                   <td>Group Name</td>
                   <td><?php echo $aggroup["aggroup_details"]->agent_group_name;?></td>
               </tr>
           </tbody>
       </table>
        <table class="table table-results" style="margin-top: 10px;">
            <thead>
                <tr>
                    <td>Code</td>
                    <td>Agent Name</td>
                    <td>Agent Location</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($aggroup["aggroup_agents"] as $agent){?>
                <tr>
                    <td><?php echo $agent->agent_code;?></td>
                    <td><?php echo $agent->agent_name;?></td>
                    <td><?php echo $agent->agent_location;?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>