<?php

/*
Template Name: Why
*/

?>

<?php get_header();?>

<section class="page-wrap">

    <div class="container">

        <h1><?php the_title()?></h1>

        <p> As a virtual research environment, openVRE aims to integrate agents and 
        pipelines to enforce a research community. To this end, we are offering you the 
        possibility to integrate your application in our platform, if you think it could 
        fit in it. We encourage you to read though this documentation and contact us for 
        any doubt or suggestion you may have. </p>
        <h3> Benefits: </h3>
        <ul>
            <li> openVRE is an open access platform, already active, published, and 
            supported by the community. openVRE offers computational and storage resources, 
            data handling utilities, user support and authentication services, on top of a 
            complete web interface. For each new agent, the web portal provides customizable 
            forms to set your application’s parameters, and tailored viewers for your 
            specific output files.</li>
            <li> openVRE agents and visualizers may complement and add extra value to your 
            application, and interoperate with them is trivial once integrated.</li>
            <li> openVRE provides an admin panel for agent developers to control and manage 
            their agents.</li>
        </ul>
        <h3> Requirements: </h3>
        <ul>
            <li> Your application or workflow should be able to run non-interactively in a 
            linux-based virtual machine (by default Ubuntu 16.04 LTS Xenial Xerus).</li>
        </ul>

        <?php get_template_part('includes/section', "content");?>

    </div>

</section>

<?php get_footer();?>