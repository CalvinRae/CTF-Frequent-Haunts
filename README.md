# Frequent Haunts
This was a CTF challenge made for Hackchester, UoM's cybersecurity society, for their Hack 'O' Lantern CTF on the 24th of October 2026, during my year as head of the society.

## Setup
Setting up the server requires adding/modifying a few files:
<ul>
  <li>db_root_password.txt, which should be set to any password of your choice</li>
  <li>.env, which should be set to db_root_password=[password], matching the password from db_root_password.txt</li>
  <li>flag1.txt, which should be set to your flag for getting a foothold (found in /var/www/flag1.txt)</li>
  <li>flag2.txt, which should be set to your flag for horizontal privilege escalation (found in /home/Caldera/flag2.txt)</li>
  <li>FrequentHaunts/map.php should be modified such that [your_key_here] is replaced with your actual google maps JS API key (this step is not strictly necessary for the challenge to function)</li>
</ul>

## Intended solution
### Foothold
<ol>
  <li>Participants can register and create posts; uploaded files are stored in [url]/uploads/</li>
  <li>Participants can discover this by fuzzing for directories or guessing using their browser (which will show 403 forbidden)</li>
  <li>They can then upload a webshell to get a foothold and read the first flag</li>
</ol>

### Horizontal Privilege Escalation
<ol>
  <li>The second flag is only readable by the user Caldera</li>
  <li>Caldera's home directory contains an entirely readable .ssh directory, including a private key</li>
  <li>The key is protected by a weak passphrase (password)</li>
  <li>Participants can copy this to their local machine, and use ssh2john and john the ripper to crack it</li>
  <li>Using the private key and its passphrase, participants can SSH into the machine as Caldera, and read the second flag</li>
</ol>

## Evaluation
### Intentions
This was intended to be an easy challenge, as many of our members were beginners with only about a month of ethical hacking experience.
As such, the foothold was designed so that it would be straightforward for most or all participants (we had gone over shells with the example of a file upload vulnerability previously).
The horizontal privilege escalation was intended to be something participants had not yet encountered but could learn during the CTF.
### Outcomes
Out of 9 teams, 4 were able to get the first flag, but only one was able to get the second, and this was by someone with much more experience than most participants.<br>
This suggests to me that the first part was largely successful, though there may have been some confusion as reverse shells would not have worked without port forwarding
(as the target machine is not on the same network).<br>
On the other hand, the second part seems to have been much more difficult than intended, although it could also come from confusion regarding the rules;
brute forcing challenges was not permitted unless explicitly stated.<br>
It is possible that participants avoided cracking the passphrase for the SSH key for fears that they would be docked points.<br>
That said, halfway through the CTF we clarified that cracking passwords locally was permitted, and not counted as brute forcing, 
which could have been a giveaway and yet we still only saw one successful solve for this part.<br>
