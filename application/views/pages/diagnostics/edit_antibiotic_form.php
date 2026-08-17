<style type="text/css">
  table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-family: sans-serif;
    font-size: 16px;
    text-align: left;
  }

  th {
    background-color: #e4e4e7 !important;
    font-weight: bold;
    padding: 12px 15px;
  }

  td {
    padding: 12px 15px;
    border-bottom: 1px solid #dddddd;
  }

  /* Odd rows */
  tbody tr:nth-child(odd) > td {
    background-color: #ffffff !important;
  }

  /* Even rows */
  tbody tr:nth-child(even) > td {
    background-color: #f8f9fa !important;
  }

  /* Hover state */
  tbody tr:hover > td {
    background-color: #f1f3f5 !important;
  }
</style>

<div class="col-md-8 col-md-offset-2">
    <?php if((isset($mode)) && ($mode == "select")){ ?>
      <center><h3>Edit Antibiotic</h3></center><br>
      <?php echo form_open('diagnostics/edit/antibiotic', array('role' => 'form')); ?>
        <div class="form-group">
          <label for="antibiotic" class="col-md-4">Antibiotic<font color='red'>*</font></label>
          <div class="col-md-8">
            <input type="text" class="form-control" placeholder="Antibiotic" id="antibiotic" name="antibiotic" 
              value="<?php echo isset($antibiotics[0]->antibiotic) ? $antibiotics[0]->antibiotic : ''; ?>" 
            />
            <?php if(isset($antibiotics[0])) { ?>
              <input type="hidden" value="<?php echo $antibiotics[0]->antibiotic_id; ?>" name="antibiotic_id" />
            <?php } ?>
          </div>
        </div>
        <div class="col-md-3 col-md-offset-4">
          <input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
        </div>
      </form>
    <?php } ?>
    
    <h3><?php if(isset($msg)) echo $msg; ?></h3> 

    <div class="col-md-12">
      <?php echo form_open('diagnostics/edit/antibiotic', array('role' => 'form', 'id' => 'antibiotic_form', 'class' => 'form-inline', 'name' => 'antibiotic')); ?>
        <h3>Search Antibiotic</h3>
        <table class="table-bordered col-md-12">
          <tbody>
            <tr>
              <td><input type="text" class="form-control" placeholder="Antibiotic" id="antibiotic" name="antibiotic"></td>
              <td><input class="btn btn-lg btn-primary btn-block" name="search" id="search" value="Search" type="submit" /></td>
            </tr>
          </tbody>
        </table>
      </form>

      <?php if(isset($mode) && $mode == "search"){ ?>
        <h3 class="col-md-12">List of Antibiotics</h3>
        <div class="col-md-12"></div>  
        <table class="table-hover table-bordered col-md-10">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Antibiotic</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $j = 1;
            foreach($antibiotics as $tg){ ?>
              <tr onclick="$('#antibiotic_form_<?php echo $tg->antibiotic_id; ?>').submit();" style="cursor: pointer;">
                <td><?php echo $j++; ?></td>
                <td>
                  <?php echo $tg->antibiotic; ?>
                  <?php echo form_open('diagnostics/edit/antibiotic', array('id' => 'antibiotic_form_' . $tg->antibiotic_id, 'role' => 'form')); ?>
                    <input type="hidden" value="<?php echo $tg->antibiotic_id; ?>" name="antibiotic_id" />
                    <input type="hidden" value="select" name="select" />
                  </form>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>
    </div>
</div>