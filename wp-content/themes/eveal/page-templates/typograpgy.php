<?php
/**
 * Template Name: Typography Page
 */
get_header(); 
?>

<div class="typography-demo" style="padding: 2rem; max-width: 800px; margin: auto; font-family: sans-serif; line-height: 1.6;">
  <!-- Headings -->
  <div class="element-group">
    <label class="selector">h1</label>
    <h1>Heading 1</h1>
  </div>
  <div class="element-group">
    <label class="selector">h2</label>
    <h2>Heading 2</h2>
  </div>

  <div class="element-group">
    <label class="selector">h3</label>
    <h3>Heading 3</h3>
  </div>

  <div class="element-group">
    <label class="selector">h4</label>
    <h4>Heading 4</h4>
  </div>

  <div class="element-group">
    <label class="selector">h5</label>
    <h5>Heading 5</h5>
  </div>

  <div class="element-group">
    <label class="selector">h6</label>
    <h6>Heading 6</h6>
  </div>

  <!-- Paragraph and Inline Tags -->
  <div class="element-group">
    <label class="selector">p</label>
    <p>This is a paragraph of text to demonstrate the default text styling.</p>
  </div>

  <div class="element-group">
    <label class="selector">a</label>
    <p><a href="#">This is a link</a></p>
  </div>

  <div class="element-group">
    <label class="selector">strong</label>
    <p><strong>This is bold text</strong></p>
  </div>

  <div class="element-group">
    <label class="selector">em</label>
    <p><em>This is italic text</em></p>
  </div>

  <div class="element-group">
    <label class="selector">u</label>
    <p><u>This is underlined text</u></p>
  </div>

  <div class="element-group">
    <label class="selector">mark</label>
    <p><mark>This is marked text</mark></p>
  </div>

  <div class="element-group">
    <label class="selector">small</label>
    <p><small>This is small text</small></p>
  </div>

  <div class="element-group">
    <label class="selector">code</label>
    <p><code>Inline code example</code></p>
  </div>

  <div class="element-group">
    <label class="selector">abbr</label>
    <p><abbr title="Cascading Style Sheets">CSS</abbr></p>
  </div>

  <!-- Blockquote -->
  <div class="element-group">
    <label class="selector">blockquote</label>
    <blockquote>
      “Design is intelligence made visible.”<br>
      <cite>— Alina Wheeler</cite>
    </blockquote>
  </div>

  <!-- Pre & Code -->
  <div class="element-group">
    <label class="selector">precode</label>
    <pre><code>const hello = () = console.log("Hello World");</code></pre>
  </div>

  <!-- Lists -->
  <div class="element-group">
    <label class="selector">ul</label>
    <ul>
      <li>Unordered item 1</li>
      <li>Unordered item 2</li>
    </ul>
  </div>

  <div class="element-group">
    <label class="selector">ol</label>
    <ol>
      <li>Ordered item 1</li>
      <li>Ordered item 2</li>
    </ol>
  </div>

  <div class="element-group">
    <label class="selector">dl</label>
    <dl>
      <dt>Term 1</dt>
      <dd>Description 1</dd>
    </dl>
  </div>

  <!-- Table -->
  <div class="element-group">
    <label class="selector">table</label>
    <table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
      <thead>
        <tr>
          <th>Heading 1</th>
          <th>Heading 2</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Data 1</td>
          <td>Data 2</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- HR -->
  <div class="element-group">
    <label class="selector">hr</label>
    <hr>
  </div>

  <!-- Sup & Sub -->
  <div class="element-group">
    <label class="selector">sup</label>
    <p>E = mc<sup>2</sup></p>
  </div>

  <div class="element-group">
    <label class="selector">sub</label>
    <p>H<sub>2</sub>O</p>
  </div>

  <!-- Form Elements -->
  <div class="element-group">
    <label class="selector">form with Inputs</label>
    <form>
      	<div class="field-group">
        <label for="text">Text Input:</label><br>
        <input type="text" id="text" placeholder="Enter text">
      </div>

      <div class="field-group">
        <label for="email">Email Input:</label><br>
        <input type="email" id="email" placeholder="you@example.com">
      </div>

      <div class="field-group">
        <label for="password">Password Input:</label><br>
        <input type="password" id="password">
      </div>

      <div class="field-group">
        <label for="select">Select Box:</label><br>
            <select id="select">
            <option value="">Please choose</option>
            <option>Option 1</option>
            <option>Option 2</option>
            </select>
        </div>
    <div class="field-group">
            <label class="selector">Radio Buttons:</label><br>
            <label class="selector"><input type="radio" name="radio"> Option A</label><br>
            <label class="selector"><input type="radio" name="radio"> Option B</label>
        </div>

      <div class="field-group">
        <label class="selector">Checkboxes:</label><br>
        <label class="selector"><input type="checkbox"> Checkbox 1</label><br>
        <label class="selector"><input type="checkbox"> Checkbox 2</label>
      </div>
		
	  <div class="field-group">
      
        <label for="textarea">Textarea:</label><br>
        <textarea id="textarea" rows="4" cols="30" placeholder="Enter message..."></textarea>
      </div>

      <div>
        <button type="submit">Submit Button</button>
        <input type="reset" value="Reset Button">
      </div>
    </form>
  </div>

</div>
<?php get_footer(); ?>