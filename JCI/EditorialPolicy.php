<?php
/*********************************************************************************************
 * Original Author: Benjamin Brackett
 * Date of origination: 03/28/2016
 *
 * Page created for use in the JCI Project.
 * Project work is done as part of a Capstone class ISYS489: Ferris State University.
 * Purpose of Page: This is the EditorialPolicy.php and will serve as the Editorial Policy 
 * content of the site.
 ********************************************************************************************/

  $page_title = 'About Us';
	include ('includes/Header.php');
	include('includes/TableRowHelper.php');
	require('../DbConnector.php');
?>

<!DOCTYPE html>
<html>
<body>
<H1>Editorial Policy</H1>
<h2>Critical Incident Content</h2>
<p>The <i>Journal of Critical Incidents (JCI)</i> publishes outstanding teaching critical incidents 
	drawn from research in real organizations, dealing with important issues in all administration-related 
	disciplines. The <i>JCI</i> specializes in decision-focused critical incidents based on original primary research 
	(e.g., interviews with key decision-makers in the organization; interviews with stakeholders affected by an 
	organizational decision, issue, or problem; participant observation; review of primary materials, such as 
	legal proceedings, congressional testimony, or internal company or stakeholder documents) supplemented by 
	appropriate secondary research (e.g., journalist accounts). Exceptional critical incidents that are analytical 
	or descriptive rather than decision-focused will be considered when a decision focus is not practicable. 
	Critical incidents based entirely on secondary sources will be considered only in unusual circumstances. 
	<i>JCI</i> also publishes occasional articles concerning critical incident research, critical incident writing 
	or critical incident teaching.
	Previously published critical incidents or articles (except those appearing in Proceedings or workshop presentations) 
	are not eligible for consideration. The <i>JCI</i> does not accept fictional works or composite critical incidents 
	synthesized from author experience.	Multi-media critical incidents or critical incident supplements will be accepted for review. Contact the journal 
	editor for instructions.
</p>
<h2>Critical Incident Format</h2>
<p>The following link provides an example of a properly formatted case/critical incident.
<a href="https://www.sfcr.org/docs/SCR_Manuscript_Guidelines_for_Authors.pdf">www.sfcr.org/docs/SCR_Manuscript_Guidelines_for_Authors.pdf</a> 
Critical incidents and articles submitted for review should be single- spaced, with 12-point font and 1" margins. Published critical incidents are no longer than 3 pages long including exhibits. All critical incidents should be written in the past tense except for quotations that refer to events contemporaneous with the decision focus.
Begin the critical incident with the following disclaimer statement: This critical incident was prepared by the authors and is intended to be used as a basis for class discussion. The views represented here are those of the authors and do not necessarily reflect the views of the Society for Case Research. The views are based on professional judgment. Copyright © 201x by the Society for Case Research and the authors. No part of this work may be reproduced or used in any form or by any means without the written permission of the Society for Case Research.
Figures and tables should be embedded in the text and numbered separately. Exhibits should be grouped at the end of the critical incident. Figures, tables, and exhibits should have a number and title as well as a source. Necessary citations of secondary sources (e.g., quotes, data) should be included in endnotes; otherwise, a "Reference List" can be included at the end of the critical incident in APA format. Footnotes may be used for short explanations when including these explanations in the body of the text would significantly disrupt the flow of the critical incident.
Acknowledgements can be included in a first page footnote after the critical incident is accepted for publication, and should include any prior conference presentation of the critical incident.
</p>
<h2>Teaching Note</h2>
<p>The following link provides an example of a properly developed teaching note.
<a href="https://www.sfcr.org/docs/SCR_Manuscript_Guidelines_for_Authors.pdf">www.sfcr.org/docs/SCR_Manuscript_Guidelines_for_Authors.pdf</a> 

Critical incidents must be accompanied by a comprehensive  Teaching Note that includes at least the following elements:
1.	Disclaimer – Use the following disclaimer statement: This teaching note was prepared by the authors and is intended to be used as a basis for class discussion. The views represented here are those of the authors and do not necessarily reflect the views of the Society for Case Research. The views are based on professional judgment. Copyright © 201x by the Society for Case Research and the authors. No part of this work may be reproduced or used in any form or by any means without the written permission of the Society for Case Research
2.	Overview – A one paragraph synopsis of the critical incident.
3.	Identification of the intended course(s) and levels, and, where possible, include the critical incident's position within the course.
4.	Research Methods – Theoretical linkages, including associated readings or theoretical material that instructors might assign to students or draw on to relate the critical incident to their field or to the course.  Also, disclose the research basis for gathering the critical incident information, including any relationship between critical incident authors and the organization, or how access to critical incident data was obtained. Include any disguises imposed and their extent. Authors should disclose the relationship between this critical incident and any other critical incidents or articles published about this organization by these authors without revealing the authors' identity during the review process.
5.	Learning Outcomes – A list of specific outcomes the student should be able to achieve in completing the critical incident assignment. 
6.	Discussion Questions – Questions for student preparation.  Include in each question a reference to one or more specific learning outcome(s). 
7.	Answers to Discussion Questions – Develop a full and complete analysis of each question that, where appropriate, also demonstrates application of relevant theory to the critical incident. This discussion may highlight analytic points that might be noticed only by the best students.  Include all relevant tables, charts and/or figures and necessary references to the critical incident.  State all assumptions made in developing the answer.  Also indicate any relevant materials or information used which were outside the boundaries of the critical incident.
8.	General Discussion – Suggested teaching approaches or a teaching plan, including the expected flow of discussion and key questions, role plays, debates, use of audiovisuals or in-class handouts, a board plan, etc. Authors are strongly encouraged to classroom test a critical incident before submission so that experience in teaching the critical incident can be discussed in the Teaching Notes.
9.	Epilogue – If appropriate, an epilogue or follow-up information about the decision actually made.
</p>
<h2>Review process</h2>
<p>All manuscripts (both the critical incident and the teaching notes) are double-blind refereed by ad hoc reviewers. Most submissions require at least two rounds of revision before acceptance. The target time frame from submission to author feedback for each version is 30 to 60 days.</p>
<h2>Publication Ethics Policy and Malpractice Statement</h2>
<h3>Author Responsibilities</h3>
<ul>
	<li>All authors are members in good standing of the Society of Case Research </li>
	<li>Publication Guidelines followed</li>
	<li>Original Work</li>
	<li>Manuscript not currently submitted or published elsewhere</li>
	<li>Authorships based upon significant contribution</li>
	<li>All listed co-authors have seen and approved final version of case and agreed to publication </li>
	<li>Authors must identify all sources used in the creation of their work (including persons that did not meet the criteria for authorship)</li>
	<li>Images, tables, or other material pulled directly from other sources must have signed permission to publish from original source </li>
	<li>Authenticity of data</li>
	<li>Conflict of interests (editor notified)</li>
	<li>Disclosure of Financial Support (relevant to the case study)</li>
	<li>Fundamental Errors (authors provide retractions or corrections)</li>
	<li>All authors must participate in the peer review process</li>
</ul>
<h3>Reviewer Responsibilities</h3>
<ul>
	<li>Contribution to Editorial Decisions (assist editors with acceptance decision and authors to improve the manuscript)</li>
	<li>Confidentiality of submissions and reviews must be maintained</li>
	<li>Acknowledgement of Sources Verified</li>
	<li>Standards of Objectivity (no personal criticism of author(s))</li>
	<li>Express Views Clearly with Supporting Arguments </li>
	<li>Plagiarism, Fraud, and Other Ethical Concerns Reported to Editor</li>
	<li>Relevant Works not Cited</li>
	<li>Notify Editor if Conflicts of Interest present (if serious do not review)</li>
	<li>Privileged information gained through the review process must not be used for personal gain</li>
	<li>Promptness (agreed upon deadlines must be met)</li>
	<li>Reviewer misconduct (in the event of reviewer misconduct these are the repercussions….)</li>
</ul>
<h3>Editor Responsibilities</h3>
<ul>
	<li>Publication Decisions (accept/reject/revise & resubmit)</li>
	<li>Review of Manuscripts (verify originality then sent to blind review)</li>
	<li>Fair Play Review (reviewed without regard for gender, race, religion, citizenship ,etc.)</li>
	<li>Confidentiality</li>
	<li>Disclosure and Conflicts of Interest (Editor will not use submission for their own research without author agreement)</li>
	<li>Ethical Guidelines (ensure publication conforms to international ethic guidelines)</li>
	<li>Proof of Misconduct (rejects not based upon suspicions, but on proof of misconduct)</li>
</ul>
<h3>Publication Responsibilities</h3>
<ul>
	<li>Clear Process</li>
	<li>Double-blind Peer reviewed</li>
	<li>Factors taken into account for review (relevance, soundness, significance, originality, readability, and language)</li>
	<li>Possible Decisions</li>
	<li>No guarantee of acceptance after 2nd review</li>
	<li>No research in more than one publication</li>
	<li>Legal requirements regarding libel, copyright infringement, and plagiarism will be strictly enforced</li>
</ul>
<h3>Author Certification</h3>
<p>
The author(s) should also be willing to certify to the following statement.
</p>
<p> 
In submitting this critical incident to the <i>Journal of Critical Incidents</i> for widespread distribution in print and electronic media, I (we) certify that it is original work, based on real events in a real organization. It has not been published and is not under review elsewhere. Copyright holders have given written permission for the use of any material not permitted by the "Fair Use Doctrine." The host organization(s) or individual informant(s) have provided written authorization allowing publication of all information contained in the critical incident that was gathered directly from the organization and/or individual.
</p>
<h2>Critical Incident Permission to Publish</h2>
<p>
	The following link provides an example of a critical incident release form.
	</p>
<a href="https://www.sfcr.org/docs/SAMPLE%20RELEASE%20FORMS.pdf" target="_blank">www.sfcr.org/docs/SAMPLE%20RELEASE%20FORMS.pdf</a>
<p>
	It is the author(s)'s responsibility to ensure that they have permission from the protagonist and/or company featured to publish material contained in the critical incident. A critical incident release form will need to be submitted by the author to the journal editor prior to publication.
	</p>
<h2>Distribution of published critical incidents</h2>
<p>
	The right to reproduce a critical incident in a commercially available textbook, or instructor-created course pack, is reserved to SCR and the authors, who share copyright for these purposes. After publication, JCI critical incidents are distributed through SCR's distribution partners according to non-exclusive contracts. SCR charges royalty fees for these publication rights and critical incident adoptions in order to fund its operations including publication of the Journal of Critical Incidents. 
	</p>
<h2>Manuscript Submission </h2>
<p>
Submit the critical incident manuscript and Teaching Notes in one <b>Microsoft Word document via the Society for Case Research</b> https://www.sfcr.org/jci/ No identification of authors or their institutions should appear on either the Critical Incident or the Teaching Notes. All identifying information should be removed from the file properties.  
A cover page with the critical incident title, names of all authors and their institutions along with contact information for the primary author including email, phone and mailing address should be sent as a separate file.
All authors must be a member of the Society for Case Research. Membership dues are included in annual registration for the MBAA conference, or may be paid separately at the rate of U.S. $50 per year. See instructions on the SCR site <a></a> https://www.sfcr.org/members/signup.php.
</p>
<br />
<p>For questions, contact the Editor:
Tim Brotherton
jci@ferris.edu
</p>
</body>
</html>
<?php
	include ('includes/Footer.php');
?>