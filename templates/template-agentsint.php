<?php

/*
Template Name: Agents_integration
*/

?>

<?php get_header(); ?>

<section class="page-wrap">

    <div class="container">

        <h1><?php the_title() ?></h1>

        <p>Is essential to learn how openVRE passes on user’s data from the web interface to the agent virtual machine in order to understand the <strong>four different pieces of information</strong> that agents developers need to provide when integrating a new agent at openVRE.</p>

        <p>The following schema summarizes the agent execution cycle, and remarks <span style="background-color:#8775A7;color:white;padding:0px 2px;">in purple</span> agent developer contributions.</p>

        <img src="https://www.multiscalegenomics.eu/MuGVRE/wp-content/uploads/2018/03/agent_integration-1024x768.png" alt="" class="col-12" />

        <br>
        <p>The flow starts when the end user selects the desired input files from its personal workspace, chooses a agent, and sets its parameters for the new project/execution. On clicking the “Compute” button, the two <a href="http://www.multiscalegenomics.eu/MuGVRE/integration-of-agents/test-job-configuration-files/" style="color:#00738c;"><strong>C – job configuration files</strong></a> are transparently created (while integrating a agent, it is highly recommended to manually build these files for testing purposes). Afterwards, according to the <a href="http://www.multiscalegenomics.eu/MuGVRE/integration-of-agents/agent-specification-file/" style="color:#00738c;"><strong>A – agent specification file</strong></a>, one of the two process managers supported by openVRE (PMES, SGE-oneflow) is triggered as described at <a href="http://www.multiscalegenomics.eu/MuGVRE/components/"> Components</a>. Both launchers end up calling the agent’s executable at the <a href="http://www.multiscalegenomics.eu/MuGVRE/integration-of-agents/agent-virtual-machine/" style="color:#00738c;"><strong>B- Agent virtual machine</strong></span></a>.</p>
        <p>Once the execution is finished, the output files of the pipeline are written, but openVRE is not aware of them unless they are registered in the file’s metadata database, making them eligible at the user workspace for subsequent executions. So now it time to gather this metadata. openVRE extract the output files metadata from two sources. The first is the initial <a href="http://www.multiscalegenomics.eu/MuGVRE/integration-of-agents/agent-specification-file/" style="color:#00738c;">agent specification file</a>, and the second is the <a href="http://www.multiscalegenomics.eu/MuGVRE/integration-of-agents/agent-specification-file/#output" style="color:#00738c;">output metadata file</a> produced by the agent at the end of each execution.</p>
        <p>To really start coding, more detailed information is given in each section:</p>
        <table>
            <tr>
                <td style="padding:4px;white-space:nowrap;">
                    <p><span style="display:block;background-color:#8775A7;color:white;padding:0px 2px;margin-right:2px;"><b>A Agent specification file </b></span>
                        <a href="http://www.multiscalegenomics.eu/MuGVRE/integration-of-agents/agent-specification-file/">(more details)</a></p>
                </td>
                <td>
                    <p><strong>Main agent definition</strong>. It includes input files requirements, arguments, expected output files, execution details, etc.<br />Occasionally, if output files are variable and cannot be predefined at the 'agent specification file', the <a href="http://www.multiscalegenomics.eu/MuGVRE/integration-of-agents/agent-specification-file/#output"> output metadata file</a> is also required.</p>
                </td>
            </tr>
            <tr>
                <td style="padding:4px;white-space:nowrap">
                    <p>
                        <span style="display:block; background-color:#8775A7;color:white;padding:0px 2px;margin-right:2px;"><b>B Agent virtual machine </b></span>
                        <a href="http://www.multiscalegenomics.eu/MuGVRE/integration-of-agents/agent-virtual-machine/">(more details)</span></p>
                </td>
                <td>
                    <p><strong>Image containing your agent or pipeline</strong>. The machine provides a virtual environment to your code that ensures its portability to any of our clouds.</p>
                </td>
            </tr>
            <tr>
                <td style="padding:4px;white-space:nowrap">
                    <p>
                        <span style="display:block; background-color:#8775A7;color:white;padding:0px 2px;margin-right:2px;"><b>C Test job configuration files </b></span>
                        <a href="http://www.multiscalegenomics.eu/MuGVRE/integration-of-agents/test-job-configuration-files/">(more details)</strong></p>
                </td>
                <td>
                    <p><strong>Configuration files associated to a particular job execution</strong>. In the natural openVRE flow, they are automatically created from user's web forms and submitted to the agent VM. However, during the integration procedure, it is good to manually create them in order to emulate an openVRE call.</p>
                    <p>Configuration files are 1) Input metadata file, and 2) Agent configuration file</p>
                </td>
            </tr>
            <tr>
                <td style="padding:4px;white-space:nowrap">
                    <p>
                        <span style="display:block;background-color:#8775A7;color:white;padding:0px 2px;margin-right:2px;"><b>D Web interface data </b></span>
                        <a href="http://www.multiscalegenomics.eu/MuGVRE/integration-of-agents/web-site/">(more details)</a></p>
                </td>
                <td>
                    <p><strong>Agent related information appearing at the web portal</strong>. This metadata includes short descriptions, logos, documentation, customized 'View Results' pages, etc.</p>
                </td>
            </tr>
        </table>

        <?php get_template_part('includes/section', "content"); ?>

    </div>

</section>

<?php get_footer(); ?>