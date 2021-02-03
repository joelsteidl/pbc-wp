import React from 'react';
import {Alert} from 'antd';
import png from '../../images/multiselect.jpg';

const FAQ = props =>{

    return(
        <div style={{background:'#fff',padding:'60px 40px',margin:'20px 40px 10px 40px'}} >
        
            <h3>What are Font Schemes ?</h3>
            <p className='faq-answer'>
                    A font scheme is just an alias for a font family, which you can assign to a group of 
                fields that may use the same font. For example: If all the headings in your website, 
                use the same font family, just save the font as a scheme and assign the scheme as the 
                font family value for the individual fields. If you want to change the font of all the 
                headings at a later point in time, you don’t have to edit each field individually. All you 
                have to do is to edit the font scheme.
            </p>
            
            <h3>What are the responsive break points ( screen sizes )  used for demarcate different devices ?</h3>
            <Alert 
                message='Devices are classified based on screen resolutions and not the actual device. So an actual laptop with a screen resolution of 1920px would still use the desktop values.' 
                type='info' />
                <br/>
            <p className='faq-answer'> Desktops -  Screen size &gt; 1377px. <br/>
                Laptops - Screen size between 1024px - 1377px <br/>
                Tablets - Screen size 768px - 1024px<br/>
                Mobile - Screen size &lt; 768px</p>



            <h3>How to edit multiple fields at once ?</h3>
            < p className='faq-answer'>
            You can multi select and edit fields as long as they have the same properties. So you have to filter the items based on fields types, for ex: filter by font-family and subsequently you will be able to select and edit all the fields that have this property. 
            </p>
            
            <img src={`${window.typehub_server_config.plugin_url}/admin/js/multiselect.jpg`} style={{marginBottom:20}} />

            <h3>How to upload a custom font ?</h3>
            <p style={{marginBottom:10}} className='faq-answer'>
                1. Go to <a href='https://web-font-generator.com' target="_blank" >Web Font Generater</a><br/>
                2. Upload your font's source OTF / TTF file ( DO NOT check the Embed font data in CSS option )<br/>
                3. Generate web font and download the package<br/>
                4. Go to the Custom Fonts tab inside Typehub and upload the webfont package<br/>
                5. That's it, you can now use your custom font for any of the font options.</p>
                Here is a quick <a href="https://youtu.be/4kR7qCgMfQA" target="_blank" >video</a> of how its done
                <br/>
                <br/>
                <br/>

            <h3>How to add a custom font programmatically ?</h3>
            <p className='faq-answer'>
            Custom fonts can be added programatically using the API’s exposed by the plugin. To add a custom font, simply register the font using the "typehub_register_font" hook. A sample code that you can add to the functions.php file of your child theme, is shown below.
            </p>
            <pre style={{background:'#f1f1f1',padding:30}} >
{
`add_action( 'typehub_register_font', 'my_typehub_custom_font' );
function my_typehub_custom_font() {
    $font = array(
        'name' => 'CUSTOM FONT NAME',
        'src' => get_stylesheet_directory_uri().'/fonts/fonts.css',  // URL of your font's stylesheet. Assuming its inside the fonts folder of your child or main theme
        'variants' => array(
            '300' => 'Light',
            '400' => 'Normal',
            '500' => 'Medium',
            '700' => 'Heavy'
            )
    );
typehub_register_font( $font );
}`}
            </pre> 

            <h3>Can typehub be used with all themes ?</h3>
            <p className='faq-answer'>Typehub is currently bundled along with the Oshine theme, however it can be used with any other theme or plugin. It provides api's for themes and plugins to register their own options and by default typehub allows you to control all the headings and body text. Developer documentation will be available soon.</p>
           
            <h3>Can I download the Google Fonts use to my Local Server ?</h3>
            <p className='faq-answer'>Yes. Use the settings Icon in the Top Right corner to download the google fonts that are used to your local server. Any new fonts added / changed can be downloaded once you have SAVED the typehub Settings.</p>
           
            <h3>Does it support typekit fonts ?</h3>
            <p className='faq-answer'>  Yes. Use the settings Icon in the Top Right corner to add your Type Kit Id and Save the settings. You will then be able to use your Type Kit Fonts.</p>
            <br/>
        < p className='faq-answer'>If you have any feedback or issues, please reach out to us at <a href="mailto:help@brandexponents.com" >help@brandexponents.com</a> and we will be happy to assist.</p>

        <h4>Typehub was crafted by the team at <a href="https://www.brandexponents.com/" target="_blank" >BRAND EXPONENTS</a>.</h4>
        </div>
    )
}

export default FAQ;